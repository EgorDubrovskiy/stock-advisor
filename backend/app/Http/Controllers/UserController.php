<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Events\SaveAvatarEvent;
use App\Events\UserDeleteEvent;
use App\Http\Requests\UserAvatarRequest;
use App\ModelRemoveContainers\UserRemoveContainer;
use App\Models\User;
use App\Services\Models\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UpdateUserRequest;
use App\Events\UserUpdatedEvent;
use Illuminate\Support\Facades\Storage;
use App\Events\ValidateRegistrationEvent;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * @param UserRequest $request
     * @param UserService $userService
     * @return JsonResponse
     */
    public function saveUser(UserRequest $request, UserService $userService) : JsonResponse
    {
        $validated = $request->validated();
        $newUser = $userService->create($validated);
        event(new ValidateRegistrationEvent($newUser));
        $this->response->data['user'] = $newUser;

        return new JsonResponse($this->response, JsonResponse::HTTP_CREATED);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function readInfo(int $id) : JsonResponse
    {
        $user = User::findOrFail($id);
        if ($user->cant('readInfo', $user)) {
            $this->response->error['id'] = 'Wrong id access';
            return new JsonResponse($this->response, JsonResponse::HTTP_FORBIDDEN);
        }
        $user->bookmarks->makeHidden('user_id');
        return response()->json($user);
    }

    /**
     * @param int $id
     * @param UserRemoveContainer $userRemoveContainer
     * @return JsonResponse
     * @throws \Throwable
     */
    public function deleteUser(int $id, UserRemoveContainer $userRemoveContainer) : JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            $this->response->error['id'] = 'user was not found';
            return new JsonResponse($this->response, JsonResponse::HTTP_NOT_FOUND);
        }
        if ($user->cant('delete', $user)) {
            $this->response->error['id'] = 'user does not have permission to delete';
            return new JsonResponse($this->response, JsonResponse::HTTP_FORBIDDEN);
        }

        $userRemoveContainer->run($user);

        event(new UserDeleteEvent($user));

        return new JsonResponse($this->response);
    }

    /**
     * @param UserAvatarRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function saveUserAvatar(UserAvatarRequest $request, int $id): JsonResponse
    {
        $user = User::findOrFail($id);

        $validated = $request->validated();
        $avatar = $validated['avatar'];

        if ($user->avatar) {
            Storage::delete(['avatars/' . $user->avatar, 'avatars/cropped' . $user->avatar]);
        }

        $extension = $avatar->extension();
        $avatarName = 'avatar_' . $id . '.' . $extension;
        $request->avatar->move(public_path('storage/app/avatars'), $avatarName);

        $user->avatar = $avatarName;
        $user->save();

        event(new SaveAvatarEvent($avatarName));

        $this->response->data['user'] = $user;

        return new JsonResponse($this->response, JsonResponse::HTTP_CREATED);
    }

    /**
     * Gets user avatar link
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getUserAvatar(int $id)
    {
        $user = User::findOrFail($id);

        $avatarName = $user->avatar;

        if (!$avatarName) {
            $this->response->error['error'] = 'User with the id '.$id.' has no avatar';
            return new JsonResponse($this->response, JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->response->data['avatar_path'] = url('/storage/app/avatars/' . $avatarName);
        return new JsonResponse($this->response, JsonResponse::HTTP_OK);
    }

    /**
     * @param UpdateUserRequest $request
     * @param int $id
     * @param UserService $userService
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, UserService $userService, int $id) : JsonResponse
    {
        $user = User::findOrFail($id);
        $validated = $request->validated();
        $this->response->data['user'] = $validated;

        $userService->update($user, $validated);
        event(new UserUpdatedEvent($user));

        return new JsonResponse($this->response);
    }

    /**
     * @param string $token
     * @return JsonResponse
     */
    public function activateUser(string $token) : JsonResponse
    {
        $user = User::where('activation_token', $token)->first();
        if ($user) {
            $user->activation_token = null;
            $user->save();
            $this->response->data['message'] = 'Account has been activated';
            return new JsonResponse($this->response, JsonResponse::HTTP_ACCEPTED);
        }
        $this->response->error = 'Account has already been activated or does not exist';
        return new JsonResponse($this->response, JsonResponse::HTTP_NOT_FOUND);
    }
}
