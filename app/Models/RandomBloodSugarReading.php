<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RandomBloodSugarReading extends Model
{
    protected $fillable = [
        'patient_id',
        'date',
        'time',
        'random_blood_sugar',
        'random_blood_sugar_unit',
        'insulin_dose',
        'insulin_dose_unit',
        'symptoms',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'random_blood_sugar' => 'decimal:2',
            'insulin_dose' => 'decimal:2',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
