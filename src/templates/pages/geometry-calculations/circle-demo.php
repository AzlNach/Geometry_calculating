
<?php 
require_once(__DIR__ . '/../../layouts/head.php');
?>

<!-- Circle Demo Section -->
<section class="demo-section mb-5">
    <div class="container">
        <h2 class="text-center mb-4">Circle Calculator</h2>
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Circle Calculator</h3>
                    </div>
                    <div class="card-body">
                        <form id="demo-circle-form">
                            <div class="mb-3">
                                <label for="demo-radius" class="form-label">Radius:</label>
                                <input type="range" class="form-range" id="demo-radius" min="10" max="100" value="50">
                                <div class="d-flex justify-content-between">
                                    <span>10</span>
                                    <span id="demo-radius-value">50</span>
                                    <span>100</span>
                                </div>
                            </div>
                        </form>
                        <div class="alert alert-info mt-3" id="demo-circle-area">
                            Area: 7854
                        </div>
                        <div class="alert alert-info mt-3" id="demo-circle-circumference">
                            Circumference: 314
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Visualization</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="svg-container" style="position: relative; width: 100%; height: 0; padding-bottom: 75%; overflow: hidden;">
                            <svg id="demo-circle-svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 300 225" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: #f8f9fa; border-radius: 0 0 5px 5px;">
                                <!-- Coordinate grid -->
                                <pattern id="grid-circle" width="30" height="30" patternUnits="userSpaceOnUse">
                                    <path d="M 30 0 L 0 0 0 30" fill="none" stroke="#e0e0e0" stroke-width="0.5"/>
                                </pattern>
                                <rect width="100%" height="100%" fill="url(#grid-circle)" />
                                
                                <!-- Circle visualization -->
                                <circle id="demo-circle" cx="150" cy="122.5" r="50" fill="rgba(59, 89, 152, 0.2)" stroke="#3b5998" stroke-width="2" />
                                
                                <!-- Radius line -->
                                <line id="demo-radius-line" x1="150" y1="122.5" x2="200" y2="122.5" stroke="red" stroke-width="2" stroke-dasharray="5,3" />
                                
                                <!-- Measurement labels -->
                                <g id="radius-label">
                                    <rect x="212" y="15" width="85" height="24" rx="5" fill="white" stroke="#3b5998" />
                                    <text id="demo-radius-text" x="255" y="32" text-anchor="middle" fill="#3b5998" font-weight="bold">Radius: 50</text>
                                </g>
                                
                                <g id="area-label-circle">
                                    <rect x="7" y="15" width="89" height="24" rx="5" fill="#3b5998" stroke="#3b5998" />
                                    <text id="demo-area-circle-text" x="52" y="32" text-anchor="middle" fill="white" font-weight="bold">Area: 7854</text>
                                </g>
                                
                                <g id="circumference-label">
                                    <rect x="102" y="15" width="104" height="24" rx="5" fill="#3b5998" stroke="#3b5998" />
                                    <text id="demo-circumference-text" x="155" y="32" text-anchor="middle" fill="white" font-weight="bold">Circum: 314</text>
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="<?= BASE_URL ?>/index.php" class="btn btn-outline-primary">Back to Home</a>
        </div>
    </div>
</section>

<!-- Add the custom JavaScript for the circle calculator -->
<script src="<?= JS_URL ?>/circle.js"></script>

<?php 
require_once(__DIR__ . '/../../layouts/foot.php');
?>