<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
                        'message' => trans('dashboard.general.not_found',[],$request->header('accept-language')),
                        'data' => null
                    ], Response::HTTP_NOT_FOUND);

                case $throwable instanceof AuthenticationException:
                    return response()->json([
                        'status' => false ,
                        'message' => trans('auth.unauth',[],$request->header('accept-language')) ,
                        'data' => null
                    ],Response::HTTP_UNAUTHORIZED);
            }
        }
        return parent::render($request, $throwable);
    }
}
