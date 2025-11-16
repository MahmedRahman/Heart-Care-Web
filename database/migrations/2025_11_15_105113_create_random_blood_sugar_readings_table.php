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
        Schema::create('random_blood_sugar_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->date('date');
            $table->time('time');
            $table->decimal('random_blood_sugar', 6, 2)->comment('Random Blood Sugar value');
            $table->string('random_blood_sugar_unit', 10)->default('mg/dL')->comment('Random Blood Sugar Unit');
            $table->decimal('insulin_dose', 6, 2)->nullable()->comment('Insulin Dose');
            $table->string('insulin_dose_unit', 10)->nullable()->comment('Insulin Dose Unit');
            $table->text('symptoms')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('random_blood_sugar_readings');
    }
};
