<?php

// Define base paths
define('BASE_DIR', realpath(__DIR__ . '/..'));
define('PUBLIC_DIR', BASE_DIR . '/public');
define('TEMPLATES_DIR', BASE_DIR . '/src/templates');

// URL paths for assets
define('BASE_URL', '/Geometry_calculating'); // Update this if your web root is different
define('PUBLIC_URL', BASE_URL . '/public');
define('JS_URL', PUBLIC_URL . '/js');
define('CSS_URL', PUBLIC_URL . '/css');
define('ASSETS_URL', PUBLIC_URL . '/assets');
define('IMAGES_URL', ASSETS_URL . '/images');
