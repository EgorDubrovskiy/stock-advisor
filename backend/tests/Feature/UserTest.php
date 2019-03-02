<?php

namespace Tests\Feature;

use App\Http\Response;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

/**
 * Class UserTest
 * @package Tests\Feature
 */
class UserTest extends TestCase
{
    public function testOnCreateSuccess()
    {
        $fields = [
            'email' => 'testOnCreate@mail.ru',
            'login' => 'testOnCreateLogin',
            'password' => 'testOnCreatePassword'
        ];

        $response = $this->json('POST', 'api/users', $fields);
        $response->assertStatus(JsonResponse::HTTP_CREATED);

        $rightResponse = new Response();
        $user = User::where('email', $fields['email'])->first();
        $rightResponse->data['user'] = [
            'login' => $user->login,
            'password' => $user->password,
            'email' => $user->email,
            'id' => $user->id
        ];
        $response->assertJsonMissingExact([$rightResponse]);
    }

    public function testOnCreateBadRequest()
    {
        $response = $this->json('POST', 'api/users');
        $response->assertStatus(JsonResponse::HTTP_BAD_REQUEST);

        $rightResponse = [
            'data',
            'pagination',
            'sorting',
            'search',
            'error' => [
                'password',
                'email'
            ]
        ];
        $response->assertJsonStructure($rightResponse);
    }

    /**
     * @depends testOnCreateSuccess
     */
    public function testOnUpdateSuccess()
    {
        $fields = [
            'email' => 'TestOnCreate@NewMail.ru',
            'password' => 'TestOnCreateNewPassword'
        ];
        $userId = User::where('email', 'testOnCreate@mail.ru')->first()->id;

        $response = $this->json(
            'PUT',
            'api/users/' . $userId,
            $fields
        );
        $response->assertStatus(JsonResponse::HTTP_OK);

        $rightResponse = new Response();
        $user = User::where('email', 'TestOnCreate@NewMail.ru')->first();
        $rightResponse->data['user'] = [
            'email' => $user->email,
            'password' => $user->password,
        ];
        $response->assertJsonMissingExact([$rightResponse]);
    }

    public function testOnUpdateNotFound()
    {
        $fields = [
            'email' => 'TestOnCreate@NewMailForCheckNotFound.ru',
            'password' => 'TestOnCreateNewPassword'
        ];
        $userId = PHP_INT_MAX;

        $response = $this->json(
            'PUT',
            'api/users/' . $userId,
            $fields
        );
        $response->assertStatus(JsonResponse::HTTP_NOT_FOUND);

        $rightResponse = [
            'data',
            'pagination',
            'sorting',
            'search',
            'error' => [
                'error'
            ]
        ];
        $response->assertJsonStructure($rightResponse);
    }

    /**
     * @depends testOnUpdateSuccess
     */
    public function testOnDeleteSuccess()
    {
        $user = User::where('email', 'TestOnCreate@NewMail.ru')->first();
        Auth::login($user);

        $response = $this->json(
            'DELETE',
            'api/users/' . $user->id,
            ['Authorization' => 'Bearer ' . Auth::tokenById($user->id)]
        );
        $response->assertStatus(JsonResponse::HTTP_OK);

        $rightResponse = new Response();
        $response->assertJsonMissingExact([$rightResponse]);
    }

    /**
     * @depends testOnUpdateSuccess
     */
    public function testOnDeleteForbidden()
    {
        $user = User::where('email', 'TestOnCreate@NewMail.ru')->first();

        $response = $this->json(
            'DELETE',
            'api/users/' . $user->id
        );
        $response->assertStatus(JsonResponse::HTTP_FORBIDDEN);

        $rightResponse = [
            'data',
            'pagination',
            'sorting',
            'search',
            'error' => [
                'id'
            ]
        ];
        $response->assertJsonStructure($rightResponse);
    }
}
