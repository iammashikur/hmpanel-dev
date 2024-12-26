<?php

use App\Models\User;
use App\Models\Connection;
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

test('it gets connection_type connections', function () {
    $connectionType = ConnectionType::factory()->create();
    $connections = Connection::factory()
        ->count(2)
        ->create([
            'connection_type_id' => $connectionType->id,
        ]);

    $response = $this->getJson(
        route('api.connection-types.connections.index', $connectionType)
    );

    $response->assertOk()->assertSee($connections[0]->name);
});

test('it stores the connection_type connections', function () {
    $connectionType = ConnectionType::factory()->create();
    $data = Connection::factory()
        ->make([
            'connection_type_id' => $connectionType->id,
        ])
        ->toArray();

    $response = $this->postJson(
        route('api.connection-types.connections.store', $connectionType),
        $data
    );

    unset($data['created_at']);
    unset($data['updated_at']);

    $this->assertDatabaseHas('connections', $data);

    $response->assertStatus(201)->assertJsonFragment($data);

    $connection = Connection::latest('id')->first();

    $this->assertEquals($connectionType->id, $connection->connection_type_id);
});
