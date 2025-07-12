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
    if (!Schema::hasTable('plans')) {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // 'Gratis', 'Medio', 'Pro'
            $table->unsignedInteger('token_limit'); // Límite de tokens
            $table->decimal('price', 8, 2)->default(0);
            $table->timestamps();
        });
    }
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
