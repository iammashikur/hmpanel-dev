<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ConnectionType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConnectionTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ConnectionType::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
        ];
    }
}
