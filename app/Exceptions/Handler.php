<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    // ...

    public function register()
    {
        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                if ($e instanceof ValidationException) {
                    return ApiResponse::error('Validation failed', 422, $e->errors());
                }
                if ($e instanceof AuthorizationException) {
                    return ApiResponse::error('Unauthorized access', 401);
                }
                if ($e instanceof ModelNotFoundException) {
                    return ApiResponse::error('Resource not found', 404);
                }
                return ApiResponse::error('Server error: ' . $e->getMessage(), 500);
            }
        });
    }
}
