<?php

namespace WingingIT\Themes\Middleware;

use Closure;
use Nette\Loaders\RobotLoader;
use ReflectionClass;

class LoadThemesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $themeDir = app_path('/../Themes');

        $robotLoader = new  RobotLoader();
        $robotLoader->setTempDirectory(__DIR__ . '/../storage/framework/cache/themes');
        $robotLoader->addDirectory($themeDir);
        $robotLoader->acceptFiles = ['*.php']; // optional to reduce file count
        $robotLoader->rebuild();

        $foundClasses = array_keys($robotLoader->getIndexedClasses());

        foreach ($foundClasses as $class) {
            $reflect = new ReflectionClass($class);
            if ($reflect->implementsInterface(\WingingIT\Themes\Theme::class)) {
                $theme = new $class();
                view()->addNamespace($theme->getBladeNameSpace(), $themeDir . '/' . $theme->getKey() . '/views/');
            }
        }
        if(config('theme.active') == null) {
            echo 'Active theme not set, did you run <b>php artisan vendor:publish --provider="WingingIT\Themes\ThemeServiceProvider"</b>?';
            die();
        };
        $activeThemeClass = 'Themes\\' . config('theme.active') . '\\' . config('theme.active');
        $activeTheme = new $activeThemeClass();
        if(file_exists($themeDir . $activeTheme->getKey())) {
            echo 'Active theme not set, did you run "php artisan vendor:publish" for the config files?';
            die();
        };
        return $next($request);
    }
}
