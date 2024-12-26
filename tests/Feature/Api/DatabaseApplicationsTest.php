<?php

use App\Models\User;
use App\Models\Database;
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

test('it gets database applications', function () {
    $database = Database::factory()->create();
    $applications = Application::factory()
        ->count(2)
        ->create([
            'database_id' => $database->id,
        ]);

    $response = $this->getJson(
        route('api.databases.applications.index', $database)
    );

    $response->assertOk()->assertSee($applications[0]->name);
});

test('it stores the database applications', function () {
    $database = Database::factory()->create();
    $data = Application::factory()
        ->make([
            'database_id' => $database->id,
        ])
        ->toArray();

    $response = $this->postJson(
        route('api.databases.applications.store', $database),
        $data
    );

    unset($data['created_at']);
    unset($data['updated_at']);

    $this->assertDatabaseHas('applications', $data);

    $response->assertStatus(201)->assertJsonFragment($data);

    $application = Application::latest('id')->first();

    $this->assertEquals($database->id, $application->database_id);
});
