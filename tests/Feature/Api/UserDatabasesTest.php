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

test('it gets user databases', function () {
    $user = User::factory()->create();
    $databases = Database::factory()
        ->count(2)
        ->create([
            'user_id' => $user->id,
        ]);

    $response = $this->getJson(route('api.users.databases.index', $user));

    $response->assertOk()->assertSee($databases[0]->name);
});

test('it stores the user databases', function () {
    $user = User::factory()->create();
    $data = Database::factory()
        ->make([
            'user_id' => $user->id,
        ])
        ->toArray();

    $data['password'] = \Str::random('8');

    $response = $this->postJson(
        route('api.users.databases.store', $user),
        $data
    );

    unset($data['password']);

    unset($data['created_at']);
    unset($data['updated_at']);

    $this->assertDatabaseHas('databases', $data);

    $response->assertStatus(201)->assertJsonFragment($data);

    $database = Database::latest('id')->first();

    $this->assertEquals($user->id, $database->user_id);
});
