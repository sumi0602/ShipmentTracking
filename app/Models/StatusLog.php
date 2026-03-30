<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StatusLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id',
        'status',
        'location',
        'note',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    public function getIconAttribute(): string
    {
        return match ($this->status) {
            Shipment::STATUS_DELIVERED  => '✓',
            Shipment::STATUS_IN_TRANSIT => '⟳',
            default                     => '◎',
        };
    }

    public function getBadgeClassAttribute(): string
    {
        return match ($this->status) {
            Shipment::STATUS_DELIVERED  => 'badge--delivered',
            Shipment::STATUS_IN_TRANSIT => 'badge--transit',
            default                     => 'badge--pending',
        };
    }
}
