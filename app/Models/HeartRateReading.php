<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HeartRateReading extends Model
{
    protected $fillable = [
        'patient_id',
        'date',
        'time',
        'heart_rate',
        'symptoms',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'heart_rate' => 'integer',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
