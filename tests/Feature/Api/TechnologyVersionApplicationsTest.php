<?php

use App\Models\User;
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

test('it gets technology_version applications', function () {
    $technologyVersion = TechnologyVersion::factory()->create();
    $applications = Application::factory()
        ->count(2)
        ->create([
            'technology_version_id' => $technologyVersion->id,
        ]);

    $response = $this->getJson(
        route('api.technology-versions.applications.index', $technologyVersion)
    );

    $response->assertOk()->assertSee($applications[0]->name);
});

test('it stores the technology_version applications', function () {
    $technologyVersion = TechnologyVersion::factory()->create();
    $data = Application::factory()
        ->make([
            'technology_version_id' => $technologyVersion->id,
        ])
        ->toArray();

    $response = $this->postJson(
        route('api.technology-versions.applications.store', $technologyVersion),
        $data
    );

    unset($data['created_at']);
    unset($data['updated_at']);

    $this->assertDatabaseHas('applications', $data);

    $response->assertStatus(201)->assertJsonFragment($data);

    $application = Application::latest('id')->first();

    $this->assertEquals(
        $technologyVersion->id,
        $application->technology_version_id
    );
});
