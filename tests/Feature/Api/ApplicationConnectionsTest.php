<?php

use App\Models\User;
use App\Models\Connection;
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

test('it gets application connections', function () {
    $application = Application::factory()->create();
    $connections = Connection::factory()
        ->count(2)
        ->create([
            'application_id' => $application->id,
        ]);

    $response = $this->getJson(
        route('api.applications.connections.index', $application)
    );

    $response->assertOk()->assertSee($connections[0]->name);
});

test('it stores the application connections', function () {
    $application = Application::factory()->create();
    $data = Connection::factory()
        ->make([
            'application_id' => $application->id,
        ])
        ->toArray();

    $response = $this->postJson(
        route('api.applications.connections.store', $application),
        $data
    );

    unset($data['created_at']);
    unset($data['updated_at']);

    $this->assertDatabaseHas('connections', $data);

    $response->assertStatus(201)->assertJsonFragment($data);

    $connection = Connection::latest('id')->first();

    $this->assertEquals($application->id, $connection->application_id);
});
