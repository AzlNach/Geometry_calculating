<?php

class Router {
    private $routes = [];
    private $baseDir;
    
    public function __construct($baseDir) {
        $this->baseDir = $baseDir;
        
        // Define comprehensive routes
        $this->routes = [
            '/' => 'public/index.php',
            '/index.php' => 'public/index.php',
            
            // Geometry calculations
            '/geometry-calculations.php' => 'src/templates/pages/geometry-calculations.php',
            '/triangle-demo.php' => 'src/templates/pages/geometry-calculations/triangle-demo.php',
            '/square-demo.php' => 'src/templates/pages/geometry-calculations/square-demo.php',
            '/circle-demo.php' => 'src/templates/pages/geometry-calculations/circle-demo.php',
            
            // Conversion calculators
            '/conversion-calculator.php' => 'src/templates/pages/conversion-calculator.php',
            '/unit-conversion.php' => 'src/templates/pages/conversion-calculator/unit-conversion.php',
            '/digital-data-converter.php' => 'src/templates/pages/digital-data-converter.php',
            '/temperature-converter.php' => 'src/templates/pages/temperature-converter.php',
            '/time-converter.php' => 'src/templates/pages/time-converter.php',
            
            // Function grapher - PERBAIKAN MAPPING
            '/function-grapher-calculator.php' => 'src/templates/pages/function-grapher-calculator.php',
            '/function-grapher.php' => 'src/templates/pages/function-grapher-calculator/function-grapher.php',
            '/parametric-grapher.php' => 'src/templates/pages/function-grapher-calculator/parametric-grapher.php',
            '/polar-grapher.php' => 'src/templates/pages/function-grapher-calculator/polar-grapher.php',
            '/3d-function-grapher.php' => 'src/templates/pages/function-grapher-calculator/3d-function-grapher.php',
            
            // Statistics
            '/statistics-calculator.php' => 'src/templates/pages/statistics-calculator.php'
        ];
    }
    
    public function resolve($uri) {
        // Parse URL and remove query parameters
        $uri = parse_url($uri, PHP_URL_PATH);
        
        // Handle base path removal - support both with and without trailing slash
        $basePath = '/Geometry_calculating_R';
        
        if (strpos($uri, $basePath . '/') === 0) {
            $uri = substr($uri, strlen($basePath));
        } elseif ($uri === $basePath) {
            $uri = '/';
        }
        
        // Ensure URI starts with /
        if (empty($uri) || $uri[0] !== '/') {
            $uri = '/' . ltrim($uri, '/');
        }
        
        // Debug logging
        error_log("Router Debug - Original URI: " . $_SERVER['REQUEST_URI']);
        error_log("Router Debug - Processed URI: " . $uri);
        error_log("Router Debug - Available routes: " . implode(', ', array_keys($this->routes)));
        
        // Check if route exists
        if (isset($this->routes[$uri])) {
            $filePath = $this->baseDir . '/' . $this->routes[$uri];
            error_log("Router Debug - Mapped to file: " . $filePath);
            
            if (file_exists($filePath)) {
                error_log("Router Debug - File exists, returning: " . $filePath);
                return $filePath;
            } else {
                error_log("Router Debug - File does not exist: " . $filePath);
            }
        }
        
        // Return 404 if no route matched
        error_log("Router Debug - No route found for: " . $uri);
        header("HTTP/1.0 404 Not Found");
        echo "404 - Page not found for URI: " . htmlspecialchars($uri);
        echo "<br>Available routes: " . implode(', ', array_keys($this->routes));
        exit;
    }
}