<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{

    use ApiResponser;

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

        $this->renderable(function (ValidationException $e) {
            return $this->errorResponse($e->validator->errors(), 422);
        });

        $this->renderable(function (NotFoundHttpException $e) {
           $message = 'Not found';
           if(Str::contains($e->getMessage(), 'model')){
            $message = explode('\\', $e->getMessage());
            $message = preg_replace('/[^A-Za-z\-]/', '', end($message)).' Not found';
           }
            
           return $this->errorResponse($message, 404);
        });

        $this->renderable(function (MethodNotAllowedHttpException $e) {
            return $this->errorResponse('Method Not Allowed', 405);
        });

        $this->renderable(function (HttpException $e) {
            return $this->errorResponse($e->getMessage(), $e->getStatusCode());
        });

        if(!(env('APP_DEBUG'))){
            $this->renderable(function (Exception $e) {
                return $this->errorResponse('Unexpected error occured!', 500);
            });
        }
    }
}
