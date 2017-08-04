<?php namespace Uncle\Libs;

use Phalcon\Mvc\Micro\Collection as MicroCollection;

class Router
{
    public static function getRoutes()
    {
        $routes = [];
        foreach (self::defineRoutes() as $controller => $controllerRoutes) {
            $controllerClass = '\\Uncle\\Controllers\\' . ucfirst($controller) . 'Controller';
            $collection = new MicroCollection();
            $collection->setHandler(new $controllerClass());
            $collection->setPrefix("/{$controller}");
            foreach ($controllerRoutes as $controllerRoute) {
                if (method_exists($controllerClass, $controllerRoute->action)) {
                    $collection->{$controllerRoute->method}($controllerRoute->path, $controllerRoute->action);
                }
            }
            $routes[] = $collection;
        }
        return $routes;
    }

    private static function defineRoutes()
    {
        return [
            'trust' => [
                (object)['method' => 'get', 'path' => '/', 'action' => 'index'],
            ],
            'adminUsers' => [
                (object)['method' => 'get', 'path' => '/', 'action' => 'index'],
            ],
        ];
    }
}
