<?php

use App\Models\User;
use App\Models\Database;
use App\Models\Technology;
use App\Models\Application;
use Laravel\Sanctum\Sanctum;
use App\Models\TechnologyVersion;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function () {
    $this->withoutExceptionHandling();

    $user = User::factory()->create(['email' => 'admin@admin.com']);

    Sanctum::actingAs($user, [], 'web');
});

test('it gets applications list', function () {
    $applications = Application::factory()
        ->count(5)
        ->create();

    $response = $this->get(route('api.applications.index'));

    $response->assertOk()->assertSee($applications[0]->name);
});

test('it stores the application', function () {
    $data = Application::factory()
        ->make()
        ->toArray();

    $response = $this->postJson(route('api.applications.store'), $data);

    unset($data['created_at']);
    unset($data['updated_at']);

    $this->assertDatabaseHas('applications', $data);

    $response->assertStatus(201)->assertJsonFragment($data);
});

test('it updates the application', function () {
    $application = Application::factory()->create();

    $technology = Technology::factory()->create();
    $technologyVersion = TechnologyVersion::factory()->create();
    $database = Database::factory()->create();
    $user = User::factory()->create();

    $data = [
        'name' => fake()->name(),
        'domain' => fake()->domainName(),
        'directory' => fake()->word(),
        'created_at' => fake()->dateTime(),
        'updated_at' => fake()->dateTime(),
        'technology_id' => $technology->id,
        'technology_version_id' => $technologyVersion->id,
        'database_id' => $database->id,
        'user_id' => $user->id,
    ];

    $response = $this->putJson(
        route('api.applications.update', $application),
        $data
    );

    unset($data['created_at']);
    unset($data['updated_at']);

    $data['id'] = $application->id;

    $this->assertDatabaseHas('applications', $data);

    $response->assertStatus(200)->assertJsonFragment($data);
});

test('it deletes the application', function () {
    $application = Application::factory()->create();

    $response = $this->deleteJson(
        route('api.applications.destroy', $application)
    );

    $this->assertModelMissing($application);

    $response->assertNoContent();
});
