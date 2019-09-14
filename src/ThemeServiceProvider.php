<?php
namespace WingingIT\Themes;

use Illuminate\Support\ServiceProvider;
use WingingIT\Themes\Commands\MakeThemeCommand;
use Illuminate\Support\Facades\Artisan;


class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/theme.php' => config_path('theme.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeThemeCommand::class,
            ]);
        }
        if(!file_exists(__DIR__ . '../../../../../Themes')) {
            mkdir(__DIR__ . '../../../../../Themes');
            Artisan::call('theme:make', [
                    'name' => ['DefaultTheme']
                ]
            );
        }
    }
}