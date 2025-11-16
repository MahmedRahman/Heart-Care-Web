<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FluidBalanceReading extends Model
{
    protected $fillable = [
        'patient_id',
        'date',
        'time',
        'fluid_intake',
        'fluid_intake_unit',
        'fluid_output',
        'fluid_output_unit',
        'net_balance',
        'net_balance_unit',
        'symptoms',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'fluid_intake' => 'decimal:2',
            'fluid_output' => 'decimal:2',
            'net_balance' => 'decimal:2',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
