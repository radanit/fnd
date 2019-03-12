<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use App\Radan\Exceptions\ResourceProtected;
use App\Radan\Exceptions\ResourceRestricted;

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
        /**
         * Check if Model not found, and request is api, 
         *   then return json response
         */
        if ($exception instanceof ModelNotFoundException && $request->wantsJson()) {            
            return response()->json([
                'message' => 'Resource not found',
                'errors' => __('app.resourceNotFound')], 404);
        }

        /**
         * Check if route not found, and request is api, 
         *   then return json response
         */
        if ($exception instanceof NotFoundHttpException && $request->wantsJson()) {            
            return response()->json([
                'message' => 'Route not found',
                'errors' => __('app.routeNotFound')], 404);
        }

        if ($exception instanceof MethodNotAllowedHttpException && $request->wantsJson()) {            
            return response()->json([
                'message' => 'Route parameter not valid',
                'errors' => __('app.routeNotFound')], 404);
        }

        if (($exception instanceof ResourceProtected or
            $exception instanceof ResourceRestricted) and
            $request->wantsJson()
        ) {
            $exception->render($request);
        }

        /**
         * Check if post file is too large size, and request is api, 
         *   then return json response
         */
        if ($exception instanceof PostTooLargeException && $request->wantsJson()) {            
            return response()->json([
                'message' => 'Post too large',
                'errors' => __('app.postTooLarg')], 404);
        }        
        
        /*return response()->json([
                'message' => $exception->getMessage(),
                'errors' => __('app.failedAlert')], 500);
        */
        return parent::render($request, $exception);
    }
}
