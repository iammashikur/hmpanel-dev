<?php

use App\Models\User;
use App\Models\Technology;
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

test('it gets technology_versions list', function () {
    $technologyVersions = TechnologyVersion::factory()
        ->count(5)
        ->create();

    $response = $this->get(route('api.technology-versions.index'));

    $response->assertOk()->assertSee($technologyVersions[0]->version);
});

test('it stores the technology_version', function () {
    $data = TechnologyVersion::factory()
        ->make()
        ->toArray();

    $response = $this->postJson(route('api.technology-versions.store'), $data);

    unset($data['created_at']);
    unset($data['updated_at']);

    $this->assertDatabaseHas('technology_version', $data);

    $response->assertStatus(201)->assertJsonFragment($data);
});

test('it updates the technology_version', function () {
    $technologyVersion = TechnologyVersion::factory()->create();

    $technology = Technology::factory()->create();

    $data = [
        'version' => fake()->word(),
        'created_at' => fake()->dateTime(),
        'updated_at' => fake()->dateTime(),
        'technology_id' => $technology->id,
    ];

    $response = $this->putJson(
        route('api.technology-versions.update', $technologyVersion),
        $data
    );

    unset($data['created_at']);
    unset($data['updated_at']);

    $data['id'] = $technologyVersion->id;

    $this->assertDatabaseHas('technology_version', $data);

    $response->assertStatus(200)->assertJsonFragment($data);
});

test('it deletes the technology_version', function () {
    $technologyVersion = TechnologyVersion::factory()->create();

    $response = $this->deleteJson(
        route('api.technology-versions.destroy', $technologyVersion)
    );

    $this->assertModelMissing($technologyVersion);

    $response->assertNoContent();
});
