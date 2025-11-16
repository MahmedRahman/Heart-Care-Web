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
        Schema::create('blood_pressure_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->date('date');
            $table->time('time');
            $table->integer('systolic_bp')->comment('Systolic Blood Pressure');
            $table->string('systolic_unit', 10)->default('mmHg')->comment('Systolic Unit');
            $table->integer('diastolic_bp')->comment('Diastolic Blood Pressure');
            $table->string('diastolic_unit', 10)->default('mmHg')->comment('Diastolic Unit');
            $table->decimal('map', 5, 2)->nullable()->comment('Mean Arterial Pressure');
            $table->string('map_unit', 10)->default('mmHg')->comment('MAP Unit');
            $table->integer('heart_rate')->nullable()->comment('Heart Rate');
            $table->string('heart_rate_unit', 10)->default('bpm')->comment('Heart Rate Unit');
            $table->text('symptoms')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_pressure_readings');
    }
};
