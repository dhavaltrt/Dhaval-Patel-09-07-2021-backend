<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
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
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
             
        if ($request->is('api/*')) {
            if($exception instanceof AuthenticationException) {
                return response()->json([
                    'message' => 'unauthenticated'
                ], 403);
            } elseif ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'message' => 'The requested route was not found on this server, please check the url.'
                ], 404);
            } else {
                return response()->json([
                    'message' => $exception->getMessage(),
                    'exceptionClass' => get_class($exception)
                ], 401);
            }
        } 

        if($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }

        return parent::render($request, $exception);
    }
}
