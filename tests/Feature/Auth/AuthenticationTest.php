<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install', ['--no-interaction' => true, '--force' => true,]);
    }
    
    public function test_users_can_authenticate_using_email_and_password(): void
    {
        $user = User::factory()->create();
        $user->roles()->sync(2);
        Passport::actingAs($user, ['BlogApp']);

        $input_data = [
            'email'    => $user->email,
            'password' => 'password'
        ];
        
        $response = $this->json('post', 'api/login', $input_data);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);

        $this->assertAuthenticated();
    }

    public function test_users_can_not_authenticate_with_invalid_email(): void
    {
        $input_data = [
            'email'    => 'wrong@email.com',
            'password' => 'password'
        ];

        $response = $this->json('post', 'api/login', $input_data);
        
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);

        $this->assertGuest();
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();
        $user->roles()->sync(2);

        $input_data = [
            'email'    => $user->email,
            'password' => 'wrong-password'
        ];

        $response = $this->json('post', 'api/login', $input_data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        
        $response->assertJsonStructure([
            'status',
            'message',
            'data'
        ]);
        
        $this->assertGuest();
    }
}
