
<?php 
require_once('layouts/head.php');
?>

<!-- Hero Section with 3D Visualization -->
<section class="hero-section mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-4 fw-bold mb-3">Geometry Calculator</h1>
                <p class="lead mb-4">Calculate area, perimeter, and volume of geometric shapes with real-time interactive visualizations.</p>
                <a href="luasindex.php" class="btn btn-primary btn-lg">Calculate Triangle Area</a>
            </div>
            <div class="col-md-6">
                <div id="hero-canvas" class="rounded shadow" style="height: 400px; background-color: #f8f9fa;"></div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section mb-5">
    <div class="container">
        <h2 class="text-center mb-4">Features</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3">
                            <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">
                                change_history
                            </span>
                        </div>
                        <h3 class="card-title">Triangle Calculations</h3>
                        <p class="card-text">Calculate the area of triangles with real-time visualization.</p>
                        <a href="triangle-demo.php" class="btn btn-outline-primary">Try Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3">
                            <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">
                                square
                            </span>
                        </div>
                        <h3 class="card-title">Square Calculations</h3>
                        <p class="card-text">Calculate the area and perimeter of squares with visualization.</p>
                        <a href="square-demo.php" class="btn btn-outline-primary">Try Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3">
                            <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">
                                radio_button_unchecked
                            </span>
                        </div>
                        <h3 class="card-title">Circle Calculations</h3>
                        <p class="card-text">Calculate the area and circumference of circles.</p>
                        <a href="#" class="btn btn-outline-primary">Coming Soon</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Interactive Demo Section -->
<section class="demo-previews-section mb-5">
    <div class="container">
        <h2 class="text-center mb-4">Interactive Demos</h2>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Triangle Calculator</h3>
                    </div>
                    <div class="card-body text-center">
                        <img src="src/gambar-geometris-segitiga-paling-mudah-21.jpg" alt="Triangle Demo" class="img-fluid mb-3" style="height: 150px; object-fit: contain; background-color: #f8f9fa;">
                        <p>Calculate the area of a triangle and see it visualized in real-time.</p>
                        <a href="triangle-demo.php" class="btn btn-outline-primary">Open Demo</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Square Calculator</h3>
                    </div>
                    <div class="card-body text-center">
                        <img src="img/square-demo-preview.png" alt="Square Demo" class="img-fluid mb-3" style="height: 150px; object-fit: contain; background-color: #f8f9fa;">
                        <p>Calculate area and perimeter of a square with interactive visualization.</p>
                        <a href="square-demo.php" class="btn btn-outline-primary">Open Demo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="why-us-section mb-5">
    <div class="container">
        <h2 class="text-center mb-4">Why Choose Our Calculator</h2>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="text-center mb-3">
                    <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">
                        real_time_update
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
<script src="js/landing.js"></script>

<?php 
require_once('layouts/foot.php');
?>