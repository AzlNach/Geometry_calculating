<?php


define('BASE_DIR', realpath(__DIR__ . '/..'));
define('PUBLIC_DIR', BASE_DIR . '/public');
define('TEMPLATES_DIR', BASE_DIR . '/src/templates');


define('BASE_URL', '/Geometry_calculating'); // Adjusted for expected subdirectory
define('PUBLIC_URL', BASE_URL); // PUBLIC_URL might need to be just BASE_URL or BASE_URL . '/public' depending on usage
                                  // Given its name, BASE_URL itself usually refers to the public root.
                                  // Let's keep PUBLIC_URL = BASE_URL as it was.

define('JS_URL', BASE_URL . '/js');
define('CSS_URL', BASE_URL . '/css');
define('ASSETS_URL', BASE_URL . '/assets');
define('IMAGES_URL', ASSETS_URL . '/images'); // This will correctly become /Geometry_calculating/assets/images
