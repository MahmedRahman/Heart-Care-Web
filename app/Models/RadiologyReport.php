<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class RadiologyReport extends Model
{
    protected $fillable = [
        'patient_id',
        'report_name',
        'report_date',
        'files',
    ];

    protected function casts(): array
    {
        return [
            'report_date' => 'date',
            'files' => 'array',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function getFilesUrlsAttribute(): array
    {
        if (!$this->files) {
            return [];
        }

        return array_map(function ($file) {
            return Storage::disk('public')->url($file);
        }, $this->files);
    }
}
