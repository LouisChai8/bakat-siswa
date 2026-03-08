<?php  
namespace App\Core;

class Router
{
    private array $routes = [];

    public function add(string $method, string $uri, string $controller, string $function): void
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'function' => $function,
        ];
    }

    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach($this->routes as $route) {
            $pattern = str_replace(
                '{id}',
                '([0-9]+)',
                $route['uri']
            );
            $pattern = '#^' . $pattern . '$#';

            if ($method === $route['method'] && preg_match($pattern, $uri, $matches)) {
                array_shift($matches);

                $controllerPath = __DIR__ . '/../controllers/' . $route['controller'] . '.php';

                if (file_exists($controllerPath)) {
                    require_once $controllerPath;
                } else {
                    die("Error: Controller file tidak ditemukan di: " . $controllerPath);
                }

                $controllerClass = 'App\\Controllers\\' . $route['controller'];
                
                if (class_exists($controllerClass)) {
                    $controller = new $controllerClass();
                    $function = $route['function'];
                    call_user_func_array([$controller, $function], $matches);
                    return;
                } else {
                    die("Error: Class $controllerClass tidak ditemukan.");
                }
            }
        }

        http_response_code(404);
        echo '<h1>404 - Page Not Found</h1>';
    }
}