<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

/**
 * Class UserRegistrationTest
 * @package Tests\Feature
 */
class UserRegistrationTest extends TestCase
{
    public function testLoginRequiredError()
    {
        $response = $this->post('/api/auth/register', [
            'email' => 'testemail@gmail.com',
            'password' => 'testtest'
        ]);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    public function testEmailRequiredError()
    {
        $response = $this->post('/api/auth/register', [
            'login' => 'testlogin',
            'password' => 'testtest'
        ]);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    public function testPasswordRequiredError()
    {
        $response = $this->post('/api/auth/register', [
            'login' => 'testlogin',
            'email' => 'testemail@gmail.com',
        ]);

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    public function testPasswordMinSizeError()
    {
        $response = $this->post('/api/auth/register', [
            'login' => 'testlogin',
            'email' => 'testemail@gmail.com',
            'password' => str_repeat('d', 7)
        ]);

        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    public function testLoginMaxSizeError()
    {
        $response = $this->post('/api/auth/register', [
            'login' => str_repeat('d', 25),
            'email' => 'testemail@gmail.com',
            'password' => 'testtest'
        ]);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    public function testEmailMaxSizeError()
    {
        $response = $this->post('/api/auth/register', [
            'login' => 'testlogin',
            'email' =>  str_repeat('d', 125),
            'password' => 'testtest'
        ]);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    public function testValidEmailError()
    {
        $response = $this->post('/api/auth/register', [
            'login' => 'testlogin',
            'email' => 'invalid+email$$$23',
            'password' => 'testtest'
        ]);
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    public function testUniqueEmailError()
    {
        $this->post('/api/auth/register', [
            'login' => 'testlogin',
            'email' => 'testemail@gmail.com',
            'password' => 'testtest'
        ])->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    public function testUniqueLoginError()
    {
        $this->post('/api/auth/register', [
            'login' => 'testlogin',
            'email' => 'testemail@gmail.com',
            'password' => 'testtest'
        ])->assertStatus(JsonResponse::HTTP_BAD_REQUEST);
    }

    public function testRegistrationResponseSuccess()
    {
        $this->post('/api/auth/register', [
            'login' => 'testlogin2',
            'email' => 'testemail2@gmail.com',
            'password' => 'testtest'
        ])->assertSuccessful();
        
        $this->assertDatabaseHas('users', [
            'login' => 'testlogin2',
            'email' => 'testemail2@gmail.com',
        ]);

        User::where('login', 'testlogin2')->delete();
    }

    public function testLoginResponseSuccess()
    {
        $this->post('/api/auth/login', [
            'login' => 'testlogin',
            'email' => 'testemail@gmail.com',
            'password' => 'testtest'
        ])->assertSuccessful()->assertJsonStructure([
            'data' => [
                'access_token',
                'token_type',
                'expires_in'
            ]]);
    }

    public function testLoginResponseUnauthorized()
    {
        $this->post('/api/auth/login', [
            'email' => 'invalidemail@gmail.com',
            'password' => 'testtest'
        ])->assertStatus(JsonResponse::HTTP_UNAUTHORIZED);
    }
}
