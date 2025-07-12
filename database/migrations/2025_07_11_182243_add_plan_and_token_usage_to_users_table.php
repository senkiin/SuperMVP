<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'plan_id')) {
            // Se asume que el plan 1 es el plan "Gratis"
            $table->foreignId('plan_id')->nullable()->after('id')->constrained('plans')->default(1);
        }
        if (!Schema::hasColumn('users', 'tokens_used')) {
            $table->unsignedInteger('tokens_used')->after('plan_id')->default(0);
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
