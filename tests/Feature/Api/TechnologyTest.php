<?php

use App\Models\User;
use App\Models\Technology;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function () {
    $this->withoutExceptionHandling();

    $user = User::factory()->create(['email' => 'admin@admin.com']);

    Sanctum::actingAs($user, [], 'web');
});

test('it gets technologies list', function () {
    $technologies = Technology::factory()
        ->count(5)
        ->create();

    $response = $this->get(route('api.technologies.index'));

    $response->assertOk()->assertSee($technologies[0]->name);
});

test('it stores the technology', function () {
    $data = Technology::factory()
        ->make()
        ->toArray();

    $response = $this->postJson(route('api.technologies.store'), $data);

    unset($data['created_at']);
    unset($data['updated_at']);

    $this->assertDatabaseHas('technologies', $data);

    $response->assertStatus(201)->assertJsonFragment($data);
});

test('it updates the technology', function () {
    $technology = Technology::factory()->create();

    $data = [
        'name' => fake()->name(),
        'created_at' => fake()->dateTime(),
        'updated_at' => fake()->dateTime(),
    ];

    $response = $this->putJson(
        route('api.technologies.update', $technology),
        $data
    );

    unset($data['created_at']);
    unset($data['updated_at']);

    $data['id'] = $technology->id;

    $this->assertDatabaseHas('technologies', $data);

    $response->assertStatus(200)->assertJsonFragment($data);
});

test('it deletes the technology', function () {
    $technology = Technology::factory()->create();

    $response = $this->deleteJson(
        route('api.technologies.destroy', $technology)
    );

    $this->assertModelMissing($technology);

    $response->assertNoContent();
});
