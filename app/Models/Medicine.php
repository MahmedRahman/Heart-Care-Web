<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Medicine extends Model
{
    protected $fillable = [
        'prescription_id',
        'medicine_name',
        'other_medicine_name',
        'medicine_image',
        'dose',
        'form',
        'route',
        'frequency',
        'time',
        'duration_value',
        'duration_unit',
        'start_date',
        'renewal_date',
        'description',
        'special_instruction',
    ];

    protected function casts(): array
    {
        return [
            'time' => 'array',
            'start_date' => 'date',
            'renewal_date' => 'date',
        ];
    }

    public function prescription(): BelongsTo
    {
        return $this->belongsTo(Prescription::class);
    }

    /**
     * Get the full URL for the medicine image
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->medicine_image) {
            return Storage::disk('public')->url($this->medicine_image);
        }
        return null;
    }
}
