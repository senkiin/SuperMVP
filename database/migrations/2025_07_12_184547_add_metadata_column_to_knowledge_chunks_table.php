<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::table('knowledge_chunks', function (Blueprint $table) {
            // Añadimos la columna 'metadata' de tipo JSONB después de la columna 'embedding'.
            // Esta columna almacenará información extra, como el document_id.
            if (!Schema::hasColumn('knowledge_chunks', 'metadata')) {
                $table->jsonb('metadata')->nullable()->after('embedding');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('knowledge_chunks', function (Blueprint $table) {
            // Esto permite revertir la migración de forma segura.
            if (Schema::hasColumn('knowledge_chunks', 'metadata')) {
                $table->dropColumn('metadata');
            }
        });
    }
};
