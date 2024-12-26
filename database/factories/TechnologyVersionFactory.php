<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\TechnologyVersion;
use Illuminate\Database\Eloquent\Factories\Factory;

class TechnologyVersionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TechnologyVersion::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'version' => fake()->word(),
            'technology_id' => \App\Models\Technology::factory(),
        ];
    }
}
