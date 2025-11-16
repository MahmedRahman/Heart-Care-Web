<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OxygenSaturationReading extends Model
{
    protected $fillable = [
        'patient_id',
        'date',
        'time',
        'oxygen_saturation',
        'oxygen_saturation_unit',
        'oxygen_delivery_method',
        'oxygen_delivery_method_unit',
        'symptoms',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'oxygen_saturation' => 'decimal:2',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
