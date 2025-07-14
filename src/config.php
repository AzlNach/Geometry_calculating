<?php

define('BASE_DIR', realpath(__DIR__ . '/..'));
define('PUBLIC_DIR', BASE_DIR . '/public');
define('TEMPLATES_DIR', BASE_DIR . '/src/templates');

// Debug mode
define('DEBUG_MODE', true);

// Auto-detect environment
$isBuiltInServer = php_sapi_name() === 'cli-server';
$isLocalhost = isset($_SERVER['HTTP_HOST']) && 
               (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || 
                strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false);

if ($isBuiltInServer || ($isLocalhost && isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != 80)) {
    // Running on built-in server or custom port
    define('BASE_URL', '');
    define('PUBLIC_URL', '');
    
    if (DEBUG_MODE) {
        error_log("Running on built-in server - Port: " . ($_SERVER['SERVER_PORT'] ?? 'unknown'));
    }
} else {
    // Running on web server
    define('BASE_URL', '/Geometry_calculating_R');
    define('PUBLIC_URL', BASE_URL . '/public');
}

define('JS_URL', PUBLIC_URL . '/js');
define('CSS_URL', PUBLIC_URL . '/css');
define('ASSETS_URL', PUBLIC_URL . '/assets');
define('IMAGES_URL', ASSETS_URL . '/images');