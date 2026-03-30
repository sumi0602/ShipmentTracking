<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Shipment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ShipmentFactory extends Factory
{
    protected $model = Shipment::class;

    private static array $cities = [
        'Mumbai', 'Delhi', 'Bangalore', 'Chennai', 'Kolkata',
        'Hyderabad', 'Pune', 'Ahmedabad', 'Jaipur', 'Surat',
        'New York', 'London', 'Dubai', 'Singapore', 'Tokyo',
    ];

    public function definition(): array
    {
        $status = $this->faker->randomElement(Shipment::STATUSES);

        return [
            'tracking_number' => strtoupper('TRK' . $this->faker->unique()->numerify('########')),
            'sender_name'     => $this->faker->name(),
            'sender_address'  => $this->faker->address(),
            'receiver_name'   => $this->faker->name(),
            'receiver_address'=> $this->faker->address(),
            'destination_city'=> $this->faker->randomElement(self::$cities),
            'status'          => $status,
            'created_at'      => $this->faker->dateTimeBetween('-60 days', 'now'),
        ];
    }

    public function pending(): static
    {
        return $this->state(['status' => Shipment::STATUS_PENDING]);
    }

    public function inTransit(): static
    {
        return $this->state(['status' => Shipment::STATUS_IN_TRANSIT]);
    }

    public function delivered(): static
    {
        return $this->state(['status' => Shipment::STATUS_DELIVERED]);
    }
}
