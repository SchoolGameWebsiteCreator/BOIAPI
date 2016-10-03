<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthenticationException::class,
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
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
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return $this->renderJsonError($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }

    /**
     * Inspect the exception and render a JSON response.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function renderJsonError($request, Exception $e)
    {
        $response = parent::render($request, $e);
        $status = $response->getStatusCode();
        $meta = [];

        switch (true) {
            case $e instanceof ModelNotFoundException:
                $title = 'Resource not found';
                $detail = 'The requested resource could not be found';
                break;
            case $e instanceof NotFoundHttpException:
                $title = 'Route not found';
                $detail = 'The requested route could not be resolved';
                break;
            case $e instanceof MethodNotAllowedHttpException:
                $title = 'Method not allowed';
                $detail = 'The method given is not allowed';
                break;
            case $e instanceof HttpResponseException:
            default:
                $title = 'Application exception';
                $detail = 'There was an application exception while fulfilling the request';
                break;
        }

        if (config('app.debug')) {
            $meta['exception'] = [
                'type' => get_class($e),
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString(),
            ];
        }
        if ($response instanceof JsonResponse) {
            $meta['data'] = $response->getData();
        }
        $responseData = [
            'error' => [
                'status' => $status,
                'title' => $title,
                'detail' => $detail,
                'code' => null,
                'meta' => $meta,
            ],
        ];

        return new JsonResponse($responseData, $status);
    }
}
