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
        Schema::table('patients', function (Blueprint $table) {
            $table->string('primary_diagnosis')->nullable()->after('language');
            $table->json('secondary_diagnosis')->nullable()->after('primary_diagnosis');
            $table->json('tertiary_diagnosis')->nullable()->after('secondary_diagnosis');
            $table->string('next_of_kin')->nullable()->after('tertiary_diagnosis');
            $table->string('clinic_name')->nullable()->after('next_of_kin');
            $table->string('physician_team_name')->nullable()->after('clinic_name');
            $table->string('nurse_name')->nullable()->after('physician_team_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn([
                'primary_diagnosis',
                'secondary_diagnosis',
                'tertiary_diagnosis',
                'next_of_kin',
                'clinic_name',
                'physician_team_name',
                'nurse_name',
            ]);
        });
    }
};
