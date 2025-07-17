<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('form_fields', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique(); // ej: 'elevator_pitch'
                $table->string('label');          // ej: 'Elevator Pitch'
                $table->string('type');           // ej: 'text', 'textarea', 'select'
                $table->json('options')->nullable(); // Para los campos 'select'
                $table->boolean('is_active')->default(true);
                $table->integer('order')->default(0);
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('form_fields');
        }
    };
    