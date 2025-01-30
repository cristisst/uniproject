<?php

namespace App\Core\Http\Routing;

use Exception;

class Router
{
    private array $routes = [];
    private bool $cacheEnabled = false;
    private string $cacheFile = __DIR__ . '/routes_cache.php';

    /**
     * Enable or disable route caching.
     *
     * @param bool $enable
     */
    public function enableCaching(bool $enable): void
    {
        $this->cacheEnabled = $enable;
    }

    /**
     * Set the cache file path.
     *
     * @param string $filePath
     */
    public function setCacheFile(string $filePath): void
    {
        $this->cacheFile = $filePath;
    }

    /**
     * Add a route to the router and persist to cache if enabled.
     *
     * @param string $method HTTP method (GET, POST, etc.).
     * @param string $path Route URI.
     * @param string $controller Controller class handling the route.
     * @param string $action Method in the controller to call.
     */
    public function addRoute(string $method, string $path, string $controller, string $action): void
    {
        $route = [
            'method' => strtoupper($method),
            'path' => $this->formatPath($path),
            'controller' => $controller,
            'action' => $action,
        ];

        $this->routes[] = $route;
    }

    /**
     * Dispatch an incoming request to the appropriate route.
     *
     * @param Request $request
     * @return void
     * @throws Exception
     */
    public function dispatch(Request $request)
    {
        $method = strtoupper($request->getMethod());
        $uri = $this->formatPath($request->getUri());

        foreach ($this->routes as $route) {
            $routePath = $route['path'];

            // Match the route and extract parameters, if any
            $params = $this->match($routePath, $uri);
            if ($route['method'] === $method && $params !== null) {
                $controllerName = $route['controller'];
                $actionName = $route['action'];

                if (!class_exists($controllerName)) {
                    $this->sendNotFound("Controller $controllerName not found");
                }

                $controller = new $controllerName();

                if (!method_exists($controller, $actionName)) {
                    $this->sendNotFound("Action $actionName not found in controller $controllerName");
                }

                // Call the controller action and pass the parameters
                return $controller->$actionName($request, ...$params);
            }
        }

        $this->sendNotFound('Route not found');
    }

    /**
     * Attempt to match a route to a request URI and extract any parameters.
     *
     * @param string $routePath
     * @param string $uri
     * @return array|null
     */
    private function match(string $routePath, string $uri): ?array
    {
        // Convert the routePath into a regex pattern with named groups
        $pattern = preg_replace('/\{([\w]+)\}/', '(?P<\1>[^/]+)', $routePath);
        $pattern = '#^' . $pattern . '$#';

        if (preg_match($pattern, $uri, $matches)) {
            // Filter only named parameters
            return array_filter(
                $matches,
                fn($key) => is_string($key),
                ARRAY_FILTER_USE_KEY
            );
        }

        return null;
    }

    /**
     * Cache the current route definitions to a file.
     */
    private function cacheRoutes(): void
    {
        $exportedRoutes = var_export($this->routes, true);
        $cacheContent = "<?php return $exportedRoutes;";
        file_put_contents($this->cacheFile, $cacheContent);
    }

    /**
     * Load routes from the cache file.
     *
     * @throws Exception
     */
    private function loadRoutesFromCache(): void
    {
        if (!file_exists($this->cacheFile)) {
            throw new Exception("Routes cache file not found at {$this->cacheFile}");
        }

        $this->routes = include $this->cacheFile;
    }

    /**
     * Clear the cached routes file, if it exists.
     */
    public function clearCache(): void
    {
        if (file_exists($this->cacheFile)) {
            unlink($this->cacheFile);
        }
    }

    /**
     * Send a 404 error response or throw an exception.
     *
     * @param string $message
     * @throws Exception
     */
    private function sendNotFound(string $message): void
    {
        throw new Exception($message);
    }

    /**
     * Format a route path by ensuring it starts with '/' and trimming extra slashes.
     *
     * @param string $path
     * @return string
     */
    private function formatPath(string $path): string
    {
        return '/' . trim($path, '/');
    }
}