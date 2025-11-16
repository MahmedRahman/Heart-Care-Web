<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class LabReport extends Model
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

    /**
     * Get the full URL for a file
     */
    public function getFileUrl($filePath): string
    {
        return Storage::disk('public')->url($filePath);
    }
}
