<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
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
        $this->renderable(function(MethodNotAllowedHttpException $e){
            return $this->errorResponse('Method Not Allowed', $e->getStatusCode());
        });

        $this->renderable(function(ValidationException $e){
            return $this->errorResponse($e->validator->errors(), 422);
        });

        $this->renderable(function(AuthenticationException $e){
            return $this->errorResponse($e->getMessage(), 401);
        });

        $this->renderable(function (NotFoundHttpException $e) {
            return $this->errorResponse('Data or URL not found', $e->getStatusCode());
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
