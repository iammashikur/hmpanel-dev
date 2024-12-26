<?php

use App\Models\User;
use App\Models\Connection;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function () {
    $this->withoutExceptionHandling();

    $user = User::factory()->create(['email' => 'admin@admin.com']);

    Sanctum::actingAs($user, [], 'web');
});

test('it gets user connections', function () {
    $user = User::factory()->create();
    $connections = Connection::factory()
        ->count(2)
        ->create([
            'user_id' => $user->id,
        ]);

    $response = $this->getJson(route('api.users.connections.index', $user));

    $response->assertOk()->assertSee($connections[0]->name);
});

test('it stores the user connections', function () {
    $user = User::factory()->create();
    $data = Connection::factory()
        ->make([
            'user_id' => $user->id,
        ])
        ->toArray();

    $response = $this->postJson(
        route('api.users.connections.store', $user),
        $data
    );

    unset($data['created_at']);
    unset($data['updated_at']);

    $this->assertDatabaseHas('connections', $data);

    $response->assertStatus(201)->assertJsonFragment($data);

    $connection = Connection::latest('id')->first();

    $this->assertEquals($user->id, $connection->user_id);
});
