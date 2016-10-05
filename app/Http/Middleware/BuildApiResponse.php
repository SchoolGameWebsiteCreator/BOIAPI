<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BuildApiResponse
{
    /**
     * Build a consistent JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $response = $next($request);

        switch (true) {
            case $response instanceof Response:
                $responseData = $response->getOriginalContent();
                break;
            case $response instanceof JsonResponse:
                $responseData = $response->getData();
                break;
        }

        if ($responseData instanceof LengthAwarePaginator) {
            $responseData = [
                'count' => $responseData->count(),
                'total' => $responseData->total(),
                'first' => $responseData->url(1),
                'next' => $responseData->nextPageUrl(),
                'previous' => $responseData->previousPageUrl(),
                'last' => $responseData->url($responseData->lastPage()),
                'data' => $responseData->getCollection()->toArray(),
            ];
        }

        return new JsonResponse(
            $responseData,
            $response->getStatusCode(),
            $response->headers->all(),
            JSON_PRETTY_PRINT
        );
    }
}
