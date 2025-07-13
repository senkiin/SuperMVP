<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB; // ¡Importante! Añadir esta línea
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Habilitar la extensión pgvector directamente con SQL.
        // Esto es más compatible que Schema::enableExtension().
        DB::statement('CREATE EXTENSION IF NOT EXISTS vector');

        Schema::create('knowledge_chunks', function (Blueprint $table) {
            $table->id();
            
            // Esta columna contendrá el texto del chunk.
            $table->text('chunk_text');
            
            // Esta columna almacenará el vector del embedding.
            // El tamaño 1536 es para el modelo text-embedding-ada-002 de OpenAI.
            $table->vector('embedding', 1536); 
            
            // Esta columna JSONB guardará toda la información extra,
            // incluyendo el 'document_id' que n8n necesita.
            $table->jsonb('metadata')->nullable(); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('knowledge_chunks');
    }
};
