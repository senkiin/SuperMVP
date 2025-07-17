<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('user_companies', function (Blueprint $table) {
            if (!Schema::hasColumn('user_companies', 'elevator_pitch')) {
                $table->text('elevator_pitch')->nullable()->after('summary');
            }
            if (!Schema::hasColumn('user_companies', 'mission_vision')) {
                $table->text('mission_vision')->nullable()->after('elevator_pitch');
            }
            if (!Schema::hasColumn('user_companies', 'products_services')) {
                $table->text('products_services')->nullable()->after('mission_vision');
            }
            if (!Schema::hasColumn('user_companies', 'target_audience')) {
                $table->text('target_audience')->nullable()->after('products_services');
            }
            if (!Schema::hasColumn('user_companies', 'value_proposition')) {
                $table->text('value_proposition')->nullable()->after('target_audience');
            }
            if (!Schema::hasColumn('user_companies', 'communication_tone')) {
                $table->string('communication_tone')->nullable()->after('value_proposition');
            }
        });
    }

    public function down()
    {
        Schema::table('user_companies', function (Blueprint $table) {
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
};