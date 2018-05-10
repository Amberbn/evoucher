<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Str;

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
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
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
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException) {
            switch (get_class($exception->getPrevious())) {
                case \Tymon\JWTAuth\Exceptions\TokenExpiredException::class:
                    return response()->json([
                        'status_code' => '401',
                        'status_message' => 'Token has expired',
                        'data' => []
                    ], $exception->getStatusCode());
                case \Tymon\JWTAuth\Exceptions\TokenInvalidException::class:
                case \Tymon\JWTAuth\Exceptions\TokenBlacklistedException::class:
                    return response()->json([
                        'status_code' => '401',
                        'status_message' => 'Token is invalid',
                        'data' => []
                    ], $exception->getStatusCode());
                case \Tymon\JWTAuth\Exceptions\TokenInvalidException::class:
                default:
                    return response()->json([
                        'status_code' => '401',
                        'status_message' => 'Token is invalid',
                        'data' => []
                    ], $exception->getStatusCode());
            }
        }   

        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, \Illuminate\Auth\AuthenticationException $exception)
    {
        if ($request->expectsJson() || Str::contains($request->header('content-type'), ['/json', 'json'])) {
            return response()->json([
                'status_code' => '401',
                'status_message' => 'Unauthenticated',
                'data' => [],
            ], 401);
        }

        return redirect()->guest(route('login'));
    }
}
