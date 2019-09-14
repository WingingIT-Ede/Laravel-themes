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
                view()->addNamespace($theme->getBladeNameSpace(), $themeDir . $theme->getKey() . '/views/');
            }
        }
        return $next($request);
    }
}
