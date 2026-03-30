<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_number',
        'sender_name',
        'sender_address',
        'receiver_name',
        'receiver_address',
        'destination_city',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public const STATUS_PENDING    = 'Pending';
    public const STATUS_IN_TRANSIT = 'In Transit';
    public const STATUS_DELIVERED  = 'Delivered';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_IN_TRANSIT,
        self::STATUS_DELIVERED,
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function statusLogs(): HasMany
    {
        return $this->hasMany(StatusLog::class)->latest();
    }

    public function latestLog(): HasMany
    {
        return $this->hasMany(StatusLog::class)->latestOfMany();
    }

    // ─── Scopes ───────────────────────────────────────────────────────────────

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (blank($term)) {
            return $query;
        }

        return $query->where('tracking_number', 'like', "%{$term}%");
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_DELIVERED  => 'badge--delivered',
            self::STATUS_IN_TRANSIT => 'badge--transit',
            default                 => 'badge--pending',
        };
    }

    public function getStatusIconAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_DELIVERED  => '✓',
            self::STATUS_IN_TRANSIT => '→',
            default                 => '○',
        };
    }

    public function isDelivered(): bool
    {
        return $this->status === self::STATUS_DELIVERED;
    }
}
