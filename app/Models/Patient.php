<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Patient extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'mobile_number',
        'telephone',
        'email',
        'hospital_id',
        'password',
        'profile_image',
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
        'primary_diagnosis',
        'secondary_diagnosis',
        'tertiary_diagnosis',
        'next_of_kin',
        'next_of_kin_phone',
        'next_of_kin_email',
        'clinic_name',
        'physician_team_name',
        'nurse_name',
        'email_verified',
        'mobile_verified',
        'email_verified_at',
        'mobile_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified' => 'boolean',
            'mobile_verified' => 'boolean',
            'email_verified_at' => 'datetime',
            'mobile_verified_at' => 'datetime',
            'date_of_birth' => 'date',
            'password' => 'hashed',
            'age' => 'integer',
            'weight' => 'decimal:2',
            'height' => 'decimal:2',
            'bsa' => 'decimal:2',
            'bmi' => 'decimal:2',
            'secondary_diagnosis' => 'array',
            'tertiary_diagnosis' => 'array',
        ];
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getProfileCompletionPercentageAttribute()
    {
        $totalFields = 0;
        $completedFields = 0;

        // Basic Information (Required)
        $basicFields = ['first_name', 'last_name', 'email', 'mobile_number', 'hospital_id'];
        foreach ($basicFields as $field) {
            $totalFields++;
            if (!empty($this->$field)) {
                $completedFields++;
            }
        }

        // Profile Information
        $profileFields = ['profile_image', 'telephone', 'country', 'city', 'address_area', 'address_street', 
                         'date_of_birth', 'gender', 'age', 'race', 'weight', 'height', 'bsa', 'bmi', 
                         'marital_state', 'language'];
        foreach ($profileFields as $field) {
            $totalFields++;
            if (!empty($this->$field)) {
                $completedFields++;
            }
        }

        // Health Information
        $healthFields = ['primary_diagnosis', 'secondary_diagnosis', 'tertiary_diagnosis', 
                        'next_of_kin', 'next_of_kin_phone', 'next_of_kin_email',
                        'clinic_name', 'physician_team_name', 'nurse_name'];
        foreach ($healthFields as $field) {
            $totalFields++;
            if ($field === 'secondary_diagnosis' || $field === 'tertiary_diagnosis') {
                if (!empty($this->$field) && is_array($this->$field) && count($this->$field) > 0) {
                    $completedFields++;
                }
            } else {
                if (!empty($this->$field)) {
                    $completedFields++;
                }
            }
        }

        if ($totalFields === 0) {
            return 0;
        }

        return round(($completedFields / $totalFields) * 100);
    }

    public function heartRateReadings()
    {
        return $this->hasMany(HeartRateReading::class);
    }

    public function radiologyReports()
    {
        return $this->hasMany(RadiologyReport::class);
    }

    public function bloodPressureReadings()
    {
        return $this->hasMany(BloodPressureReading::class);
    }

    public function oxygenSaturationReadings()
    {
        return $this->hasMany(OxygenSaturationReading::class);
    }

    public function weightReadings()
    {
        return $this->hasMany(WeightReading::class);
    }

    public function randomBloodSugarReadings()
    {
        return $this->hasMany(RandomBloodSugarReading::class);
    }

    public function fluidBalanceReadings()
    {
        return $this->hasMany(FluidBalanceReading::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}
