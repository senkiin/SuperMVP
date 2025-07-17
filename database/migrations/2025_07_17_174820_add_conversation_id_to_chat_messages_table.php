<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::table('chat_messages', function (Blueprint $table) {
                // Añadimos la clave foránea a la tabla de conversaciones
                $table->foreignId('chat_conversation_id')->after('user_id')->constrained()->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::table('chat_messages', function (Blueprint $table) {
                $table->dropForeign(['chat_conversation_id']);
                $table->dropColumn('chat_conversation_id');
            });
        }
    };
    