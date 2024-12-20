<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('test encoding/decoding a url via the api', function () {

    Sanctum::actingAs(
        User::factory()->create(),
        ['url:encode', 'url:decode']
    );
 
    $response = $this->post(
        '/api/encode',
        [
            'domain' => 'https://test.domain',
            'url' => 'https://my.superlong.test-domain.test?page=1&sort=asc'
        ]
    );
 
    $response->assertJsonIsObject();

    $response->assertStatus(201);

    $response = $this->get('/api/decode/' . $response->json()['code']);
 
    $response->assertJsonIsObject();

    $response->assertStatus(200);
});
