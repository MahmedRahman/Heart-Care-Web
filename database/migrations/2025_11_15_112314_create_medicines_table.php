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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescription_id')->constrained('prescriptions')->onDelete('cascade');
            $table->string('medicine_name')->nullable();
            $table->string('other_medicine_name')->nullable();
            $table->string('medicine_image')->nullable();
            $table->string('dose')->nullable();
            $table->string('form')->nullable();
            $table->string('route')->nullable();
            $table->string('frequency')->nullable();
            $table->json('time')->nullable()->comment('Array of times');
            $table->integer('duration_value')->nullable();
            $table->string('duration_unit')->nullable();
            $table->date('start_date')->nullable();
            $table->date('renewal_date')->nullable();
            $table->text('description')->nullable();
            $table->text('special_instruction')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
