<?php

use App\Models\User;
use App\Models\Database;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function () {
    $this->withoutExceptionHandling();

    $user = User::factory()->create(['email' => 'admin@admin.com']);

    Sanctum::actingAs($user, [], 'web');
});

test('it gets databases list', function () {
    $databases = Database::factory()
        ->count(5)
        ->create();

    $response = $this->get(route('api.databases.index'));

    $response->assertOk()->assertSee($databases[0]->name);
});

test('it stores the database', function () {
    $data = Database::factory()
        ->make()
        ->toArray();

    $data['password'] = \Str::random('8');

    $response = $this->postJson(route('api.databases.store'), $data);

    unset($data['password']);

    unset($data['created_at']);
    unset($data['updated_at']);

    $this->assertDatabaseHas('databases', $data);

    $response->assertStatus(201)->assertJsonFragment($data);
});

test('it updates the database', function () {
    $database = Database::factory()->create();

    $user = User::factory()->create();

    $data = [
        'name' => fake()->name(),
        'password' => \Str::random(8),
        'created_at' => fake()->dateTime(),
        'updated_at' => fake()->dateTime(),
        'user_id' => $user->id,
    ];

    $data['password'] = \Str::random('8');

    $response = $this->putJson(route('api.databases.update', $database), $data);

    unset($data['password']);

    unset($data['created_at']);
    unset($data['updated_at']);

    $data['id'] = $database->id;

    $this->assertDatabaseHas('databases', $data);

    $response->assertStatus(200)->assertJsonFragment($data);
});

test('it deletes the database', function () {
    $database = Database::factory()->create();

    $response = $this->deleteJson(route('api.databases.destroy', $database));

    $this->assertModelMissing($database);

    $response->assertNoContent();
});
