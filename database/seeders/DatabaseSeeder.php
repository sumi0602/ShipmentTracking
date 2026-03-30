<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Shipment;
use App\Models\StatusLog;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding shipments...');

        // ── Pending Shipments ────────────────────────────────────────────────
        Shipment::factory()
            ->count(12)
            ->pending()
            ->create()
            ->each(function (Shipment $shipment) {
                StatusLog::create([
                    'shipment_id' => $shipment->id,
                    'status'      => Shipment::STATUS_PENDING,
                    'location'    => 'Origin Warehouse',
                    'note'        => 'Shipment registered and awaiting pickup',
                    'created_at'  => $shipment->created_at,
                ]);
            });

        // ── In Transit Shipments ─────────────────────────────────────────────
        Shipment::factory()
            ->count(15)
            ->inTransit()
            ->create()
            ->each(function (Shipment $shipment) {
                $baseTime = $shipment->created_at;

                StatusLog::insert([
                    [
                        'shipment_id' => $shipment->id,
                        'status'      => Shipment::STATUS_PENDING,
                        'location'    => 'Origin Warehouse',
                        'note'        => 'Shipment registered and awaiting pickup',
                        'created_at'  => $baseTime,
                        'updated_at'  => $baseTime,
                    ],
                    [
                        'shipment_id' => $shipment->id,
                        'status'      => Shipment::STATUS_IN_TRANSIT,
                        'location'    => 'Mumbai Sorting Hub',
                        'note'        => 'Package collected and in transit',
                        'created_at'  => $baseTime->copy()->addHours(4),
                        'updated_at'  => $baseTime->copy()->addHours(4),
                    ],
                ]);
            });

        // ── Delivered Shipments ──────────────────────────────────────────────
        Shipment::factory()
            ->count(23)
            ->delivered()
            ->create()
            ->each(function (Shipment $shipment) {
                $baseTime = $shipment->created_at;

                StatusLog::insert([
                    [
                        'shipment_id' => $shipment->id,
                        'status'      => Shipment::STATUS_PENDING,
                        'location'    => 'Origin Warehouse',
                        'note'        => 'Shipment registered and awaiting pickup',
                        'created_at'  => $baseTime,
                        'updated_at'  => $baseTime,
                    ],
                    [
                        'shipment_id' => $shipment->id,
                        'status'      => Shipment::STATUS_IN_TRANSIT,
                        'location'    => 'Regional Sorting Facility',
                        'note'        => 'Package sorted and dispatched',
                        'created_at'  => $baseTime->copy()->addHours(6),
                        'updated_at'  => $baseTime->copy()->addHours(6),
                    ],
                    [
                        'shipment_id' => $shipment->id,
                        'status'      => Shipment::STATUS_IN_TRANSIT,
                        'location'    => 'Destination Hub',
                        'note'        => 'Arrived at destination city hub',
                        'created_at'  => $baseTime->copy()->addHours(30),
                        'updated_at'  => $baseTime->copy()->addHours(30),
                    ],
                    [
                        'shipment_id' => $shipment->id,
                        'status'      => Shipment::STATUS_DELIVERED,
                        'location'    => $shipment->destination_city,
                        'note'        => 'Package delivered to recipient',
                        'created_at'  => $baseTime->copy()->addHours(48),
                        'updated_at'  => $baseTime->copy()->addHours(48),
                    ],
                ]);
            });

        $this->command->info('Seeding complete! Created 50 shipments with status logs.');
    }
}
