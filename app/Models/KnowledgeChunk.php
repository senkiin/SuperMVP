<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowledgeChunk extends Model
{
    use HasFactory;

    protected $fillable = ['document_id', 'chunk_text', 'embedding'];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}