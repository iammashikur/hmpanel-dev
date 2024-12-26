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

test('it gets technology technology_versions', function () {
    $technology = Technology::factory()->create();
    $technologyVersions = TechnologyVersion::factory()
        ->count(2)
        ->create([
            'technology_id' => $technology->id,
        ]);

    $response = $this->getJson(
        route('api.technologies.technology-versions.index', $technology)
    );

    $response->assertOk()->assertSee($technologyVersions[0]->version);
});

test('it stores the technology technology_versions', function () {
    $technology = Technology::factory()->create();
    $data = TechnologyVersion::factory()
        ->make([
            'technology_id' => $technology->id,
        ])
        ->toArray();

    $response = $this->postJson(
        route('api.technologies.technology-versions.store', $technology),
        $data
    );

    unset($data['created_at']);
    unset($data['updated_at']);

    $this->assertDatabaseHas('technology_version', $data);

    $response->assertStatus(201)->assertJsonFragment($data);

    $technologyVersion = TechnologyVersion::latest('id')->first();

    $this->assertEquals($technology->id, $technologyVersion->technology_id);
});
