<?php

namespace Vadiasov\Upload;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class UploadServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $router->aliasMiddleware('upload', \Vadiasov\Upload\Middleware\UploadMiddleware::class);
        
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
//        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
//        $this->loadTranslationsFrom(__DIR__ . '/Translations', 'upload');
        $this->loadViewsFrom(__DIR__ . '/Views', 'upload');
        
//        $this->publishes([__DIR__ . '/Config/upload.php' => config_path('upload.php'),], 'upload_config');
//        $this->publishes([__DIR__ . '/Assets' => public_path('vendor/upload'),], 'upload_assets');
//        $this->publishes(
//            [
//                __DIR__ . '/Translations' => resource_path('lang/vendor/upload'),
//                __DIR__ . '/Views'        => resource_path('views/vendor/upload'),
//            ]);
        
//        if ($this->app->runningInConsole()) {
//            $this->commands([
//                \Vadiasov\Upload\Commands\UploadCommand::class,
//            ]);
//        }
    }
    
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
//        $this->mergeConfigFrom(
//            __DIR__ . '/Config/upload.php', 'upload'
//        );
        $this->app->make('Vadiasov\Upload\Controllers\UploadController');
    }
}
