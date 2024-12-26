<?php

use App\Models\User;
use App\Models\Connection;
use App\Models\Application;
use Laravel\Sanctum\Sanctum;
use App\Models\ConnectionType;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function () {
    $this->withoutExceptionHandling();

    $user = User::factory()->create(['email' => 'admin@admin.com']);

    Sanctum::actingAs($user, [], 'web');
});

test('it gets connections list', function () {
    $connections = Connection::factory()
        ->count(5)
        ->create();

    $response = $this->get(route('api.connections.index'));

    $response->assertOk()->assertSee($connections[0]->name);
});

test('it stores the connection', function () {
    $data = Connection::factory()
        ->make()
        ->toArray();

    $response = $this->postJson(route('api.connections.store'), $data);

    unset($data['created_at']);
    unset($data['updated_at']);

    $this->assertDatabaseHas('connections', $data);

    $response->assertStatus(201)->assertJsonFragment($data);
});

test('it updates the connection', function () {
    $connection = Connection::factory()->create();

    $connectionType = ConnectionType::factory()->create();
    $application = Application::factory()->create();
    $user = User::factory()->create();

    $data = [
        'name' => fake()->name(),
        'username' => fake()->word(),
        'password' => \Str::random(8),
        'access_token' => fake()->word(),
        'ip' => fake()->ipv4(),
        'port' => fake()->word(),
        'created_at' => fake()->dateTime(),
        'updated_at' => fake()->dateTime(),
        'connection_type_id' => $connectionType->id,
        'application_id' => $application->id,
        'user_id' => $user->id,
    ];

    $response = $this->putJson(
        route('api.connections.update', $connection),
        $data
    );

    unset($data['created_at']);
    unset($data['updated_at']);

    $data['id'] = $connection->id;

    $this->assertDatabaseHas('connections', $data);

    $response->assertStatus(200)->assertJsonFragment($data);
});

test('it deletes the connection', function () {
    $connection = Connection::factory()->create();

    $response = $this->deleteJson(
        route('api.connections.destroy', $connection)
    );

    $this->assertModelMissing($connection);

    $response->assertNoContent();
});
