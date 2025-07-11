<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_company_id', 
        'document_category_id',
        'original_filename', 
        'storage_path', 
        'status',
    ];

    public function userCompany()
    {
        return $this->belongsTo(UserCompany::class, 'user_company_id');
    }

    public function category()
    {
        return $this->belongsTo(DocumentCategory::class, 'document_category_id');
    }

    public function knowledgeChunks()
    {
        return $this->hasMany(KnowledgeChunk::class);
    }
}