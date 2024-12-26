<?php

namespace Database\Factories;

use App\Models\Database;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DatabaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Database::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'password' => \Hash::make('password'),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
