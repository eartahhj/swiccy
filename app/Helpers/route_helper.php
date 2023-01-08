<?php

use CodeIgniter\Router\Exceptions\RouterException;

# Multilanguage routes support
if (!function_exists('route')) {
    function route(string $routeName, ...$params) {
        $locale = service('request')->getLocale();
        $routes = service('routes');

        if (strpos($routeName, '{locale}') !== false) {
            $routeName = strtr($routeName, ['{locale}' => $locale]);
        } else {
            $routeName = $locale . '.' . $routeName;
        }
        
        $reverseRoute = $routes->reverseRoute($routeName, ...$params);

        if (!$reverseRoute) {
            throw RouterException::forInvalidRoute($routeName);
        }

        return $reverseRoute;
    }
}