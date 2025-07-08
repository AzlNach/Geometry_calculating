<?php


// Include necessary configuration and router files
require_once(__DIR__ . '/../src/config.php');
require_once(__DIR__ . '/../src/core/router.php');

$router = new Router(BASE_DIR);
$targetFile = $router->resolve($_SERVER['REQUEST_URI']);

$isHomePage = realpath($targetFile) === realpath(__FILE__);

// The router returns the full path to the file that should be included.
// This could be index.php itself or one of the template pages.
if ($isHomePage) {
    // If the router points to this file, it means we should render the main landing page.
    require_once(TEMPLATES_DIR . '/layouts/head.php');
    ?>
    
    <header class="header">
        <nav class="navbar">
            <a href="<?= BASE_URL ?>" class="logo">
                <span class="material-symbols-rounded logo-icon">calculate</span>
                GeoCalc+
            </a>
            
            <ul class="nav-links">
                <li><a href="#features-section" class="nav-link">Features</a></li>
                <li><a href="#demo-previews-section" class="nav-link">Demos</a></li>
                <li><a href="#why-us-section" class="nav-link">Why Us</a></li>
                <li><a href="<?= BASE_URL ?>/tutorials.php" class="nav-link">Tutorials</a></li>
                <li><a href="#demo-previews-section" class="btn nav-cta">Get Started</a></li>
            </ul>

            <button class="mobile-menu-toggle">
                <span class="material-symbols-rounded">menu</span>
            </button>
        </nav>
    </header>
    <!-- Hero Section with 3D Visualization -->
    <section class="hero-section mb-0">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-4 fw-bold mb-3">Geometry Calculator</h1>
                    <p class="lead mb-4">Calculate area, perimeter, and volume of geometric shapes with real-time interactive visualizations.</p>
                    <a href="#demo-previews-section" class="btn btn-primary btn-lg">Try Now</a>
                </div>
                <div class="col-md-6">
                    <div id="hero-canvas" class="rounded shadow" style="height: 400px; background-color: #f8f9fa;"></div>
                </div>
            </div>
        </div>
    </section>

        <!-- Features Section -->
        <section class="features-section mb-4" id ="features-section">
            <div class="container mt-5">
                <h2 class="text-center mb-4">Features</h2>
                <div class="carousel">
                    <div class="group">
                        <!-- First set of cards -->
                        <div class="card-container">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <div class="feature-icon mb-3">
                                        <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">
                                            change_history
                                        </span>
                                    </div>
                                    <h3 class="card-title">Geometry Calculations</h3>
                                    <p class="card-text">Calculate area, perimeter, and volume of various geometric shapes.</p>
                                    <a href="<?= BASE_URL ?>/geometry-calculations.php" class="btn btn-outline-primary">Try Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-container">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <div class="feature-icon mb-3">
                                        <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">
                                            swap_horiz
                                        </span>
                                    </div>
                                    <h3 class="card-title">Conversion Calculator</h3>
                                    <p class="card-text">Convert between various units including digital data, temperature, and time.</p>
                                    <a href="<?= BASE_URL ?>/conversion-calculator.php" class="btn btn-outline-primary">Try Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-container">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <div class="feature-icon mb-3">
                                        <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">
                                            show_chart
                                        </span>
                                    </div>
                                    <h3 class="card-title">Function Grapher Calculator</h3>
                                    <p class="card-text">Visualize mathematical functions with interactive graphing tools and multiple plotting modes.</p>
                                    <a href="<?= BASE_URL ?>/function-grapher-calculator.php" class="btn btn-outline-primary">Try Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-container">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <div class="feature-icon mb-3">
                                        <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">
                                            bar_chart
                                        </span>
                                    </div>
                                    <h3 class="card-title">Statistics Calculator</h3>
                                    <p class="card-text">Calculate mean, median, mode, and other basic statistical measures.</p>
                                    <a href="<?= BASE_URL ?>/statistics-calculator.php" class="btn btn-outline-primary">Try Now</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Duplicate cards for infinite loop effect -->
                        <div class="card-container">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <div class="feature-icon mb-3">
                                        <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">
                                            change_history
                                        </span>
                                    </div>
                                    <h3 class="card-title">Geometry Calculations</h3>
                                    <p class="card-text">Calculate area, perimeter, and volume of various geometric shapes.</p>
                                    <a href="<?= BASE_URL ?>/geometry-calculations.php" class="btn btn-outline-primary">Try Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-container">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <div class="feature-icon mb-3">
                                        <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">
                                            swap_horiz
                                        </span>
                                    </div>
                                    <h3 class="card-title">Conversion Calculator</h3>
                                    <p class="card-text">Convert between various units including digital data, temperature, and time.</p>
                                    <a href="<?= BASE_URL ?>/conversion-calculator.php" class="btn btn-outline-primary">Try Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-container">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <div class="feature-icon mb-3">
                                        <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">
                                            show_chart
                                        </span>
                                    </div>
                                    <h3 class="card-title">Function Grapher Calculator</h3>
                                    <p class="card-text">Visualize mathematical functions with interactive graphing tools and multiple plotting modes.</p>
                                    <a href="<?= BASE_URL ?>/function-grapher-calculator.php" class="btn btn-outline-primary">Try Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-container">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <div class="feature-icon mb-3">
                                        <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">
                                            bar_chart
                                        </span>
                                    </div>
                                    <h3 class="card-title">Statistics Calculator</h3>
                                    <p class="card-text">Calculate mean, median, mode, and other basic statistical measures.</p>
                                    <a href="<?= BASE_URL ?>/statistics-calculator.php" class="btn btn-outline-primary">Try Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="demo-previews-section mb-0" id="demo-previews-section">
            <div class="container">
                <div class="row" id="demo-content">
                    <!-- By default, only show Geometry Calculations -->
                    <?php include(TEMPLATES_DIR . '/pages/geometry-calculations.php'); ?>
                </div>
            </div>
        </section>

        <!-- Why Choose Us Section -->
        <section class="why-us-section mb-2" id="why-us-section">
            <div class="container">
                <h2 class="text-center mb-4 pb-5">Why Choose Our Calculator</h2>
                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="text-center mb-3">
                            <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">
                                update
                            </span>
                        </div>
                        <h4 class="text-center">Real-time Calculation</h4>
                        <p class="text-center">Instant results as you input values</p>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center mb-3">
                            <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">
                                visibility
                            </span>
                        </div>
                        <h4 class="text-center">Visual Representation</h4>
                        <p class="text-center">See your shapes come to life</p>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center mb-3">
                            <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">
                                history
                            </span>
                        </div>
                        <h4 class="text-center">Calculation History</h4>
                        <p class="text-center">Save and review previous calculations</p>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center mb-3">
                            <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">
                                devices
                            </span>
                        </div>
                        <h4 class="text-center">Responsive Design</h4>
                        <p class="text-center">Works on all devices and screen sizes</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Add Three.js library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/three@0.134.0/examples/js/controls/OrbitControls.js"></script>

        <!-- Add the custom JavaScript for the landing page -->
        <script src="<?= JS_URL ?>/landing.js"></script>
        <script src="<?= JS_URL ?>/feature-loader.js"></script>

        <?php
        require_once(TEMPLATES_DIR . '/layouts/foot.php');
        } else {
            // If the router points to a different file (e.g., triangle-demo.php), include that file.
            require_once($targetFile);
}
?>