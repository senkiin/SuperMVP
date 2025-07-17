<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class UserCompany extends Model
    {
        use HasFactory;
        
        protected $table = 'user_companies';
        
        protected $fillable = [
            'user_id', 
            'name', 
            'summary',
            'manual_data',
        ];

        protected $casts = [
            'manual_data' => 'array', 
        ];

        public function user()
        {
            return $this->belongsTo(User::class);
        }

        public function documents()
        {
            return $this->hasMany(Document::class, 'user_company_id');
        }
    }
    