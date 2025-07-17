<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class FormField extends Model
    {
        use HasFactory;

        protected $fillable = [
            'name',
            'label',
            'type',
            'options',
            'is_active',
            'order',
        ];

        protected $casts = [
            'options' => 'array',
            'is_active' => 'boolean',
        ];
    }
    