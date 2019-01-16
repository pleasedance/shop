<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
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
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
//        $this->mapAdminRoutes();
        $this->mapApiRoutes();
        $this->mapSellerRoutes();
        $this->mapCompanyRoutes();
        $this->mapSystemRoutes();
    }


    /**
     * Define the "admin" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::namespace($this->namespace)->group(base_path('routes/admin.php'));
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
        Route::prefix("api")->namespace($this->namespace."\Api")->group(base_path('routes/api.php'));
    }

    /**
     * Define the "seller" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapSellerRoutes()
    {
        Route::namespace($this->namespace)->group(base_path('routes/seller.php'));
    }

    /**
     * Define the "company" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapCompanyRoutes()
    {
        Route::namespace($this->namespace)->group(base_path('routes/company.php'));
    }

    /**
     * Define the "system" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapSystemRoutes()
    {
        Route::namespace($this->namespace)->group(base_path('routes/system.php'));
    }
}
