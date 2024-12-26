<?php

use App\Models\User;
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

test('it gets user applications', function () {
    $user = User::factory()->create();
    $applications = Application::factory()
        ->count(2)
        ->create([
            'user_id' => $user->id,
        ]);

    $response = $this->getJson(route('api.users.applications.index', $user));

    $response->assertOk()->assertSee($applications[0]->name);
});

test('it stores the user applications', function () {
    $user = User::factory()->create();
    $data = Application::factory()
        ->make([
            'user_id' => $user->id,
        ])
        ->toArray();

    $response = $this->postJson(
        route('api.users.applications.store', $user),
        $data
    );

    unset($data['created_at']);
    unset($data['updated_at']);

    $this->assertDatabaseHas('applications', $data);

    $response->assertStatus(201)->assertJsonFragment($data);

    $application = Application::latest('id')->first();

    $this->assertEquals($user->id, $application->user_id);
});
