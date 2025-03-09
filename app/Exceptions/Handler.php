<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use App\Traits\CustomResponse;

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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $exception
     * @return Response
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof QueryException) {
            return CustomResponse::error('Internal Server Error', 500);
        }
        if ($exception instanceof NotFoundHttpException) {
            return CustomResponse::error('Not Found', 404);
        }
        if ($exception instanceof ValidationException) {
            return CustomResponse::errorResponse($exception->validator->errors()->first(), 422);
        }
        if ($exception instanceof ModelNotFoundException) {
            return CustomResponse::error('Model not found', 404);
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return CustomResponse::error('Method Not Allowed', 405);
        }
        if ($exception instanceof HttpException) {
            return CustomResponse::error($exception->getMessage(), $exception->getStatusCode());
        }
        if ($exception instanceof AuthenticationException) {
            return CustomResponse::error('Authentication Failed', 401);
        }
        if ($exception instanceof UnauthorizedException) {
            return CustomResponse::error('Unauthorized', 403);
        }

        return parent::render($request, $exception);
    }
}
