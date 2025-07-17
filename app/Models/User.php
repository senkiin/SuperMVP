<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'plan_id',
        'tokens_used',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean', // Aseguramos que el campo is_admin se trate como booleano
        ];
    }

    /**
     * Define la relación con el Plan del usuario.
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Define la relación con la Compañía del usuario.
     */
    public function userCompany(): HasOne
    {
        return $this->hasOne(UserCompany::class);
    }

    /**
     * Verifica si el usuario tiene un plan específico por su nombre.
     */
    public function hasPlan(string $planName): bool
    {
        return $this->plan && $this->plan->name === $planName;
    }

    /**
     * Verifica si el usuario es un administrador.
     */
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    /**
     * Verifica si el usuario tiene tokens disponibles para gastar.
     * Los administradores siempre tienen tokens disponibles.
     */
    public function hasAvailableTokens(int $tokensToSpend): bool
    {
        if ($this->isAdmin()) {
            return true;
        }
        if (!$this->plan) {
            return false;
        }
        return ($this->tokens_used + $tokensToSpend) <= $this->plan->token_limit;
    }

    public function userCompanies(): HasMany
    {
        return $this->hasMany(UserCompany::class);
    }
    public function conversations(): HasMany
    {
        return $this->hasMany(ChatConversation::class);
    }


}
