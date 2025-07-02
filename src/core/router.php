
<?php

class Router {
    private $routes = [];
    private $baseDir;
    
    public function __construct($baseDir) {
        $this->baseDir = $baseDir;
        
        // Define default routes
        $this->routes = [
            '/' => 'public/index.php',
            '/index.php' => 'public/index.php',
            '/triangle-demo.php' => 'src/templates/pages/triangle-demo.php',
            '/square-demo.php' => 'src/templates/pages/square-demo.php',
            '/circle-demo.php' => 'src/templates/pages/circle-demo.php',
            '/geometry-calculations.php' => 'src/templates/pages/geometry-calculations.php',
            '/unit-conversion.php' => 'src/templates/pages/unit-conversion.php',
            '/function-grapher.php' => 'src/templates/pages/function-grapher.php',
            '/statistics-calculator.php' => 'src/templates/pages/statistics-calculator.php'
        ];
    }
    
    public function resolve($uri) {
        // Remove query parameters
        $uri = parse_url($uri, PHP_URL_PATH);
        
        // Remove base path from URI if present
        $basePath = '/Geometry_calculating';
        if (strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }
        
        // Default to root if URI is empty after removing base path
        if (empty($uri)) {
            $uri = '/';
        }
        
        // Check if route exists
        if (isset($this->routes[$uri])) {
            $filePath = $this->baseDir . '/' . $this->routes[$uri];
            if (file_exists($filePath)) {
                return $filePath;
            }
        }
        
        // If no route matched, return 404
        header("HTTP/1.0 404 Not Found");
        echo "404 - Page not found for URI: " . htmlspecialchars($uri);
        exit;
    }
}