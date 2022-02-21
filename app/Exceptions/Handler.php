<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $throwable)
    {
        if ($request->wantsJson()) {
            switch ($throwable) {
                case $throwable instanceof ModelNotFoundException:
                    return response()->json([
                        'status' => false,
                        'message' => trans('dashboard.general.not_found', [], $request->header('accept-language')),
                        'data' => null
                    ], 404);

                case $throwable instanceof AuthenticationException:
                    return response()->json([
                        'status' => false,
                        'message' => trans('auth.unauth', [], $request->header('accept-language')),
                        'data' => null
                    ], 401);
                case $throwable instanceof ThrottleRequestsException:
                    return response()->json([
                        'status' => false,
                        'message' => trans('auth.throttle', ['seconds' => 60], $request->header('accept-language')),
                        'data' => null
                    ], 401);
            }
        }
        
        return parent::render($request, $throwable);
    }
}
