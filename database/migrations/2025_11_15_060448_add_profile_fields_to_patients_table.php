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
            $table->string('profile_image')->nullable()->after('hospital_id');
            $table->string('telephone')->nullable()->after('mobile_number');
            $table->string('country')->nullable()->after('email');
            $table->string('city')->nullable()->after('country');
            $table->string('address_area')->nullable()->after('city');
            $table->string('address_street')->nullable()->after('address_area');
            $table->date('date_of_birth')->nullable()->after('address_street');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('date_of_birth');
            $table->integer('age')->nullable()->after('gender');
            $table->enum('race', ['african', 'asian', 'caucasian', 'hispanic', 'native_american', 'pacific_islander', 'other'])->nullable()->after('age');
            $table->decimal('weight', 5, 2)->nullable()->after('race');
            $table->decimal('height', 5, 2)->nullable()->after('weight');
            $table->decimal('bsa', 5, 2)->nullable()->after('height');
            $table->decimal('bmi', 5, 2)->nullable()->after('bsa');
            $table->enum('marital_state', ['single', 'married', 'divorced', 'widowed', 'separated'])->nullable()->after('bmi');
            $table->string('language')->nullable()->after('marital_state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn([
                'profile_image',
                'telephone',
                'country',
                'city',
                'address_area',
                'address_street',
                'date_of_birth',
                'gender',
                'age',
                'race',
                'weight',
                'height',
                'bsa',
                'bmi',
                'marital_state',
                'language',
            ]);
        });
    }
};
