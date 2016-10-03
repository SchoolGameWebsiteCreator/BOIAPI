<?php

namespace App\Providers;

use ReflectionException;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $router = $this->app->make('router');

        $this->bindResourceModels($router);

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();

        $this->mapApiRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group([
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/web.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::group([
            'middleware' => 'api',
            'namespace' => $this->namespace,
            'prefix' => 'api',
        ], function ($router) {
            require base_path('routes/api.php');
        });
    }

    /**
     * Bind all applicable resources to the router by converting the
     * resource string into a valid model.
     *
     * Aborts with a 404 if the model isn't found in the container.
     *
     * Example bindings:
     * -----------------
     * item -> App\Model\Item
     * item-type -> App\Model\ItemType
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function bindResourceModels(Router $router)
    {
        $router->bind('resource', function ($resource) {
            $parts = explode('-', $resource);

            array_walk($parts, function (&$item) {
                $item = ucwords($item);
            });

            try {
                return $this->app->make('App\\Models\\'.implode($parts));
            } catch (ReflectionException $e) {
                throw new NotFoundHttpException;
            }
        });
    }
}
