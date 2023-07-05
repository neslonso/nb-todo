<?php

namespace App\Exceptions;

use App\Core\Application\Interfaces\ApiResponseInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (\Throwable $e) {
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception): \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
    {
        if ($request->expectsJson()) {
            $apiResponse = app(ApiResponseInterface::class);

            return response()->json(
                $apiResponse::create(true, $exception->getMessage(), (object) []),
                401);
        }

        return redirect()->guest($exception->redirectTo() ?? route('login'));
    }

    protected function invalidJson($request, ValidationException $exception): \Illuminate\Http\JsonResponse
    {
        $apiResponse = app(ApiResponseInterface::class);

        return response()->json(
            $apiResponse::create(true, 'Validation error(s)', (object) $exception->errors()),
            $exception->status);
    }
}
