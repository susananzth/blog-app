<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $this->assertAuthenticated();

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
    }
}
