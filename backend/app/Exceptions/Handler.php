<?php

namespace App\Exceptions;

use App\Http\Response;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * @param Exception $exception
     * @return mixed|void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        $response = new Response();

        if ($exception instanceof ModelNotFoundException) {
            $response->error['error'] = 'Model Not Found';
            return new JsonResponse($response, JsonResponse::HTTP_NOT_FOUND);
        } elseif ($exception instanceof ValidationException) {
            foreach ($exception->errors() as $error => $messages) {
                $response->error[$error] = $messages[0];
            }
            return new JsonResponse($response, JsonResponse::HTTP_BAD_REQUEST);
        } else  {
            $response->error['error'] = '500 Internal Server Error';
            return new JsonResponse($response, JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
