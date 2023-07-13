<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->descriptiveResponseMethods();
    }

    protected function descriptiveResponseMethods()
    {
        $instance = $this;
        Response::macro('success', fn ($data): \Illuminate\Http\JsonResponse => Response::json($data, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE));
        Response::macro('error', fn ($data): \Illuminate\Http\JsonResponse => Response::json($data, 422, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE));

        Response::macro('created', function ($data): \Illuminate\Http\JsonResponse {
            if (is_countable($data) ? count($data) : 0) {
                return Response::json($data, 201);
            }

            return Response::json([], 201);
        });

        Response::macro('noContent', fn ($data = []): \Illuminate\Http\JsonResponse => Response::json([], 204));

        Response::macro('badRequest', fn ($message = 'Validation Failure', $errors = []) => $instance->handleErrorResponse($message, $errors, 400));

        Response::macro('unauthorized', fn ($message = 'User unauthorized', $errors = []) => $instance->handleErrorResponse($message, $errors, 401));

        Response::macro('forbidden', fn ($message = 'Access denied', $errors = []) => $instance->handleErrorResponse($message, $errors, 403));

        Response::macro('notFound', fn ($message = 'Resource not found.', $errors = []) => $instance->handleErrorResponse($message, $errors, 404));

        Response::macro('internalServerError', fn ($message = 'Internal Server Error.', $errors = []) => $instance->handleErrorResponse($message, $errors, 500));
    }

    public function handleErrorResponse($message, $errors, $status)
    {
        $response = [
            'message' => $message,
        ];

        if (is_countable($errors) ? count($errors) : 0) {
            $response['errors'] = $errors;
        }

        return Response::json($response, $status);
    }
}
