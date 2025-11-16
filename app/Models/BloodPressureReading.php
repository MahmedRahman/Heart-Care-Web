<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BloodPressureReading extends Model
{
    protected $fillable = [
        'patient_id',
        'date',
        'time',
        'systolic_bp',
        'systolic_unit',
        'diastolic_bp',
        'diastolic_unit',
        'map',
        'map_unit',
        'heart_rate',
        'heart_rate_unit',
        'symptoms',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'systolic_bp' => 'integer',
            'diastolic_bp' => 'integer',
            'map' => 'decimal:2',
            'heart_rate' => 'integer',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function getFormattedBpAttribute(): string
    {
        return "{$this->systolic_bp}/{$this->diastolic_bp} {$this->systolic_unit}";
    }
}
