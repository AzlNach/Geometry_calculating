
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
            '/triangle-demo.php' => 'src/templates/pages/geometry-calculations/triangle-demo.php',
            '/square-demo.php' => 'src/templates/pages/geometry-calculations/square-demo.php',
            '/circle-demo.php' => 'src/templates/pages/geometry-calculations/circle-demo.php',
            '/geometry-calculations.php' => 'src/templates/pages/geometry-calculations.php',
            '/unit-conversion.php' => 'src/templates/pages/conversion-calculator/unit-conversion.php',
            '/function-grapher.php' => 'src/templates/pages/function-grapher-calculator/function-grapher.php',
            '/statistics-calculator.php' => 'src/templates/pages/statistics-calculator.php',
            '/conversion-calculator.php' => 'src/templates/pages/conversion-calculator.php',
            '/digital-data-converter.php' => 'src/templates/pages/digital-data-converter.php',
            '/temperature-converter.php' => 'src/templates/pages/temperature-converter.php',
            '/time-converter.php' => 'src/templates/pages/time-converter.php',
            '/function-grapher-calculator.php' => 'src/templates/pages/function-grapher-calculator.php',
            '/parametric-grapher.php' => 'src/templates/pages/function-grapher-calculator/parametric-grapher.php',
            '/polar-grapher.php' => 'src/templates/pages/function-grapher-calculator/polar-grapher.php',
            '/3d-function-grapher.php' => 'src/templates/pages/function-grapher-calculator/3d-function-grapher.php'
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