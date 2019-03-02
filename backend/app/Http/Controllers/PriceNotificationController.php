<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriceNotificationRequest;
use App\Models\PriceNotification;
use App\Services\Models\PriceNotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class PriceNotificationController
 * @package App\Http\Controllers
 */
class PriceNotificationController extends Controller
{
    /**
     * @param PriceNotificationRequest $request
     * @param PriceNotificationService $priceNotificationService
     * @return JsonResponse
     */
    public function createPriceNotification(
        PriceNotificationRequest $request,
        PriceNotificationService $priceNotificationService
    ) : JsonResponse
    {
        $validated = $request->validated();
        $priceNotification = $priceNotificationService->create($validated);
        $this->response->data = $priceNotification;

        return new JsonResponse($this->response, JsonResponse::HTTP_CREATED);
    }

    /**
     * @param int $id
     * @param PriceNotificationRequest $request
     * @param PriceNotificationService $priceNotificationService
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function updatePriceNotification(
        int $id,
        PriceNotificationRequest $request,
        PriceNotificationService $priceNotificationService
    ) : JsonResponse
    {
        $validated = $request->validated();
        $priceNotification = PriceNotification::findOrFail($id);
        $this->authorize('update', $priceNotification);
        $priceNotification = $priceNotificationService->update($priceNotification, $validated);
        $this->response->data = $priceNotification;

        return new JsonResponse($this->response);
    }

    /**
     * @param int $id
     * @param PriceNotificationService $priceNotificationService
     * @return JsonResponse
     * @throws \Exception
     */
    public function  deletePriceNotification(
        int $id,
        PriceNotificationService $priceNotificationService
    ) : JsonResponse
    {
        $priceNotification = PriceNotification::findOrFail($id);
        $this->authorize('delete', $priceNotification);
        $priceNotificationService->delete($priceNotification);
        $this->response->data = 'Successfully deleted';

        return new JsonResponse($this->response);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getPriceNotification(int $id) : JsonResponse
    {
        $priceNotification = PriceNotification::findOrFail($id);
        $this->authorize('get', $priceNotification);
        $this->response->data = $priceNotification;

        return new JsonResponse($this->response);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllPriceNotifications(Request $request) : JsonResponse
    {
        $defaultItemsCount = 10;
        $defaultPageNumber = 0;
        $priceNotifications = PriceNotification::where('user_id', '=', $request->get('user_id'))
            ->limit($request->get('itemsCount', $defaultItemsCount))
            ->offset($request->get('pageNumber', $defaultPageNumber) * $request->get('itemsCount', $defaultItemsCount))
            ->get();
        $this->response->pagination = [
            'pageNumber' => $request->get('pageNumber', $defaultPageNumber),
            'itemsCount' => $request->get('itemsCount', $defaultItemsCount)
        ];
        $this->response->data = $priceNotifications;

        return new JsonResponse($this->response);
    }
}
