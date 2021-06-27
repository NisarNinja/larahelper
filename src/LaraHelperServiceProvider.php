<?php

namespace Easoblue\LaraHelper;

use Easoblue\LaraHelper\Facade\LaraHelper as LaraHelperFacade;
use Easoblue\LaraHelper\LaraHelper;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class LaraHelperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */

    public function boot()
    {

        // Register global helpers
        foreach (scandir(__DIR__.DIRECTORY_SEPARATOR.'helpers') as $helperFile) {
            $path = sprintf(
                '%s%s%s%s%s',
                __DIR__,
                DIRECTORY_SEPARATOR,
                'helpers',
                DIRECTORY_SEPARATOR,
                $helperFile
            );

            if(!config('larahelper.helpers.'.Str::before($helperFile, '.php').'.enable')){
                 continue;
            }

            if (! is_file($path)) {
                continue;
            }

            require_once $path;
        }


    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/larahelper.php', 'larahelper');
        $loader = AliasLoader::getInstance();

        $this->app->bind('LaraHelper', LaraHelper::class);
        $loader->alias('LaraHelper', LaraHelperFacade::class);
    }
}
