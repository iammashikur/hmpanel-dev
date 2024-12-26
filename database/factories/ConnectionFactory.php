<?php

namespace Database\Factories;

use App\Models\Connection;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConnectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Connection::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->word(),
            'password' => \Hash::make('password'),
            'access_token' => fake()->word(),
            'ip' => fake()->ipv4(),
            'port' => fake()->word(),
            'connection_type_id' => \App\Models\ConnectionType::factory(),
            'application_id' => \App\Models\Application::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
