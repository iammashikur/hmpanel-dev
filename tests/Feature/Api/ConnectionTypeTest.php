<?php

use App\Models\User;
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

test('it gets connection_types list', function () {
    $connectionTypes = ConnectionType::factory()
        ->count(5)
        ->create();

    $response = $this->get(route('api.connection-types.index'));

    $response->assertOk()->assertSee($connectionTypes[0]->name);
});

test('it stores the connection_type', function () {
    $data = ConnectionType::factory()
        ->make()
        ->toArray();

    $response = $this->postJson(route('api.connection-types.store'), $data);

    unset($data['created_at']);
    unset($data['updated_at']);

    $this->assertDatabaseHas('connection_types', $data);

    $response->assertStatus(201)->assertJsonFragment($data);
});

test('it updates the connection_type', function () {
    $connectionType = ConnectionType::factory()->create();

    $data = [
        'name' => fake()->name(),
        'created_at' => fake()->dateTime(),
        'updated_at' => fake()->dateTime(),
    ];

    $response = $this->putJson(
        route('api.connection-types.update', $connectionType),
        $data
    );

    unset($data['created_at']);
    unset($data['updated_at']);

    $data['id'] = $connectionType->id;

    $this->assertDatabaseHas('connection_types', $data);

    $response->assertStatus(200)->assertJsonFragment($data);
});

test('it deletes the connection_type', function () {
    $connectionType = ConnectionType::factory()->create();

    $response = $this->deleteJson(
        route('api.connection-types.destroy', $connectionType)
    );

    $this->assertModelMissing($connectionType);

    $response->assertNoContent();
});
