<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PasswordReset;
use App\Http\Requests\SendTokenPasswordRequest;
use Illuminate\Http\JsonResponse;
use App\Events\ResetPasswordEvent;
use Carbon\Carbon;
use App\Http\Requests\ResetPasswordRequest;

/**
 * Class PasswordController
 * @package App\Http\Controllers\Auth
 */
class PasswordController extends Controller
{
    /**
     * @param SendTokenPasswordRequest $request
     * @return JsonResponse
     */
    public function sendToken(SendTokenPasswordRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        $passwordReset = PasswordReset::create(
            [
                'user_id' => $user->id,
                'token' => str_random(60),
            ]
        );

        /** email user */
        event(new ResetPasswordEvent($user, $passwordReset));

        $this->response->data['message'] = 'We have e-mailed your password reset link!';
        return new JsonResponse($this->response);
    }

    /**
     * @param $token
     * @return JsonResponse
     */
    public function findToken(string $token): JsonResponse
    {
        $passwordReset = PasswordReset::where('token', $token)->first();

        if (!$passwordReset) {
            $this->response->error['token'] = 'This password reset token is not found.';
            return new JsonResponse($this->response, JsonResponse::HTTP_NOT_FOUND);
        }

        if (Carbon::parse($passwordReset->created_at)
            ->Addminutes(config('passwordTokenExpireTime.PASSWORD_TOKEN_EXPIRE_TIME'))
            ->isPast()) {
            PasswordReset::where([
                ['token', $token],
            ])->delete();
            $this->response->error['token'] = 'This password reset token is invalid.';
            return new JsonResponse($this->response, JsonResponse::HTTP_NOT_FOUND);
        }

        $this->response->data[] = $passwordReset;
        return new JsonResponse($this->response);
    }

    /**
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            $this->response->error['email'] = 'We can\'t find a user with that e-mail address.';
            return new JsonResponse($this->response, JsonResponse::HTTP_NOT_FOUND);
        }

        $passwordReset = PasswordReset::where([
            ['token', $validated['token']],
            ['user_id', $user->id]
        ])->first();

        if (!$passwordReset) {
            $this->response->error['token'] = 'This password reset token is invalid.';
            return new JsonResponse($this->response, JsonResponse::HTTP_NOT_FOUND);
        }

        /** change user password */
        $user->password = bcrypt($validated['password']);
        $user->save();
        PasswordReset::where([
            ['token', $validated['token']],
            ['user_id', $user->id]
        ])->delete();

        $this->response->data['message'] = 'Your password was successfully changed!';
        return new JsonResponse($this->response);
    }
}
