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
        Schema::create('fluid_balance_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->date('date');
            $table->time('time');
            $table->decimal('fluid_intake', 8, 2)->nullable()->comment('Fluid Intake amount');
            $table->string('fluid_intake_unit', 10)->nullable()->comment('Fluid Intake Unit (mL, L, etc.)');
            $table->decimal('fluid_output', 8, 2)->nullable()->comment('Fluid Output amount');
            $table->string('fluid_output_unit', 10)->nullable()->comment('Fluid Output Unit (mL, L, etc.)');
            $table->decimal('net_balance', 8, 2)->nullable()->comment('Net Balance (Intake - Output)');
            $table->string('net_balance_unit', 10)->nullable()->comment('Net Balance Unit');
            $table->text('symptoms')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fluid_balance_readings');
    }
};
