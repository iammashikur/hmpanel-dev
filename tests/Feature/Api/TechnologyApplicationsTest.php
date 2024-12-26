<?php

use App\Models\User;
use App\Models\Technology;
use App\Models\Application;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function () {
    $this->withoutExceptionHandling();

    $user = User::factory()->create(['email' => 'admin@admin.com']);

    Sanctum::actingAs($user, [], 'web');
});

test('it gets technology applications', function () {
    $technology = Technology::factory()->create();
    $applications = Application::factory()
        ->count(2)
        ->create([
            'technology_id' => $technology->id,
        ]);

    $response = $this->getJson(
        route('api.technologies.applications.index', $technology)
    );

    $response->assertOk()->assertSee($applications[0]->name);
});

test('it stores the technology applications', function () {
    $technology = Technology::factory()->create();
    $data = Application::factory()
        ->make([
            'technology_id' => $technology->id,
        ])
        ->toArray();

    $response = $this->postJson(
        route('api.technologies.applications.store', $technology),
        $data
    );

    unset($data['created_at']);
    unset($data['updated_at']);

    $this->assertDatabaseHas('applications', $data);

    $response->assertStatus(201)->assertJsonFragment($data);

    $application = Application::latest('id')->first();

    $this->assertEquals($technology->id, $application->technology_id);
});
