<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::table('user_companies', function (Blueprint $table) {
                // Añadimos la nueva columna JSON
                $table->json('manual_data')->nullable()->after('summary');

                // Eliminamos las columnas antiguas y fijas
                $table->dropColumn([
                    'elevator_pitch',
                    'mission_vision',
                    'products_services',
                    'target_audience',
                    'value_proposition',
                    'communication_tone',
                ]);
            });
        }

        public function down()
        {
            Schema::table('user_companies', function (Blueprint $table) {
                $table->dropColumn('manual_data');
                // Aquí podrías volver a añadir las columnas antiguas si necesitaras revertir
            });
        }
    };
    