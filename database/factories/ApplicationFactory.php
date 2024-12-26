<?php

namespace Database\Factories;

use App\Models\Application;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Application::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'domain' => fake()->domainName(),
            'directory' => fake()->word(),
            'technology_id' => \App\Models\Technology::factory(),
            'technology_version_id' => \App\Models\TechnologyVersion::factory(),
            'database_id' => \App\Models\Database::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
