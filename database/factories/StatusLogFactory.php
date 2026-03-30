<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\StatusLog;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatusLogFactory extends Factory
{
    protected $model = StatusLog::class;

    private static array $locations = [
        'Mumbai Sorting Center',
        'Delhi Hub',
        'Bangalore Warehouse',
        'Chennai Distribution',
        'Hyderabad Gateway',
        'Customs Clearance - BOM',
        'In Transit - NH48',
        'Out for Delivery',
        'Local Post Office',
        'Delivery Depot',
    ];

    private static array $notes = [
        'Package received at facility',
        'Package scanned and sorted',
        'Departed sorting center',
        'Arrived at destination hub',
        'Out for delivery to recipient',
        'Delivery attempted, recipient unavailable',
        'Successfully delivered to recipient',
        'Held at customs for inspection',
        'Cleared customs inspection',
        'Transferred to local carrier',
    ];

    public function definition(): array
    {
        return [
            'shipment_id' => Shipment::factory(),
            'status'      => $this->faker->randomElement(Shipment::STATUSES),
            'location'    => $this->faker->randomElement(self::$locations),
            'note'        => $this->faker->randomElement(self::$notes),
        ];
    }
}
