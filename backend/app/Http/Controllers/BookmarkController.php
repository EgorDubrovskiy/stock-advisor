<?php

namespace App\Http\Controllers;

use App\Events\BookmarkInserted;
use Illuminate\Http\JsonResponse;
use App\Models\{Bookmark, User, Company};

/**
 * Class BookmarkController
 * @package App\Http\Controllers
 */
class BookmarkController extends Controller
{
    /**
     * @param int $userId
     * @param int $companyId
     * @return JsonResponse
     */
    public function addBookmark(int $userId, int $companyId) : JsonResponse
    {
        $user = User::findOrFail($userId);
        $company = Company::findOrFail($companyId);

        $oldBookmark = Bookmark::withTrashed()->where('company_id', $companyId)
            ->where('user_id', $userId);
        if (!is_null($oldBookmark->first()) && !$oldBookmark->first()->trashed()) {
            $this->response->error = 'Company already in bookmarks';
            return new JsonResponse($this->response, JsonResponse::HTTP_NOT_FOUND);
        }

        if (!is_null($oldBookmark->first()) && $oldBookmark->first()->trashed()) {
            $oldBookmark->restore();
        } else {
            $user->companies()->attach($company);
        }

        event(new BookmarkInserted($user, $company));
        $this->response->data = ['Message' => 'Bookmark added'];

        return new JsonResponse($this->response);
    }

    /**
     * @param int $userId
     * @return JsonResponse
     */
    public function getBookmarks(int $userId) : JsonResponse
    {
        $user = User::findOrFail($userId);
        if ($user->cant('readInfo', $user)) {
            $this->response->error['id'] = 'Wrong id access';
            return new JsonResponse($this->response, JsonResponse::HTTP_FORBIDDEN);
        }

        $bookmarks = Bookmark::with('company')
            ->where('user_id', $userId)
            ->get();

        $this->response->data['bookmarks'] = $bookmarks;
        return new JsonResponse($this->response, JsonResponse::HTTP_OK);
    }

    /**
     * @param int $userId
     * @param int $companyId
     * @return JsonResponse
     */
    public function deleteBookmark(int $userId, int $companyId) : JsonResponse
    {
        $user = User::findOrFail($userId);
        if ($user->cant('readInfo', $user)) {
            $this->response->error['id'] = 'Wrong id access';
            return new JsonResponse($this->response, JsonResponse::HTTP_FORBIDDEN);
        }

        $bookmark = Bookmark::where('user_id', $userId)->where('company_id', $companyId);
        if (!$bookmark->first()) {
            $this->response->error['bookmark'] = 'No such bookmark';
            return new JsonResponse($this->response, JsonResponse::HTTP_NOT_FOUND);
        }

        $bookmark->delete();

        $this->response->data = ['Message' => 'Bookmark was deleted'];
        return new JsonResponse($this->response, JsonResponse::HTTP_OK);
    }
}
