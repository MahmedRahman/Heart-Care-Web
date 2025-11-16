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
        Schema::create('oxygen_saturation_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->date('date');
            $table->time('time');
            $table->decimal('oxygen_saturation', 5, 2)->comment('Oxygen Saturation percentage');
            $table->string('oxygen_saturation_unit', 10)->default('%')->comment('Oxygen Saturation Unit');
            $table->string('oxygen_delivery_method')->nullable()->comment('Oxygen Delivery Method');
            $table->string('oxygen_delivery_method_unit', 20)->nullable()->comment('Oxygen Delivery Method Unit (e.g., L/min)');
            $table->text('symptoms')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oxygen_saturation_readings');
    }
};
