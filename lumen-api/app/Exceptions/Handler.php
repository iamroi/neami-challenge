<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
//use Flugg\Responder\Exceptions\Handler as ExceptionHandler;
//use Flugg\Responder\Exceptions\Http\ValidationFailedException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
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
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            throw new \Flugg\Responder\Exceptions\Http\PageNotFoundException();
        }

        if ($exception instanceof \Illuminate\Validation\ValidationException) {
//            throw new ValidationFailedException($exception->validator);
            return responder()->error($exception->getMessage())
                ->data(['fields' => $exception->validator->errors()->getMessageBag()->toArray()])
                        ->respond();
        };

        if ($exception instanceof \Illuminate\Http\Exceptions\HttpResponseException) {
            return responder()->error($exception->getMessage())
                ->respond($exception->getStatusCode());
        };

        return parent::render($request, $exception);
    }
}
