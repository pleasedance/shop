<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
        
        if($exception instanceof AppException){
            return \ResponseHelper::error($exception->getMessage(),NULL,NULL,400);
        }elseif($exception instanceof SessionException){
            if(\Request::ajax()){
                return \ResponseHelper::error($exception->getMessage(),NULL,NULL,403);
            }
            return redirect("/passport");
        }elseif($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException){
            echo '接口不存在';exit;
        }
        return parent::render($request, $exception);
    }
}
