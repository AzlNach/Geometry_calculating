
<?php 
require_once(__DIR__ . '/../../layouts/head.php');
?>

<!-- Interactive Triangle Demo Section -->
<section class="demo-section mb-5">
    <div class="container">
        <h2 class="text-center mb-4">Triangle Area Calculator</h2>
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Triangle Area Calculator</h3>
                    </div>
                    <div class="card-body">
                        <form id="demo-triangle-form">
                            <div class="mb-3">
                                <label for="demo-base" class="form-label">Base:</label>
                                <input type="range" class="form-range" id="demo-base" min="20" max="150" value="80">
                                <div class="d-flex justify-content-between">
                                    <span>20</span>
                                    <span id="demo-base-value">80</span>
                                    <span>150</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="demo-height" class="form-label">Height:</label>
                                <input type="range" class="form-range" id="demo-height" min="20" max="150" value="60">
                                <div class="d-flex justify-content-between">
                                    <span>20</span>
                                    <span id="demo-height-value">60</span>
                                    <span>150</span>
                                </div>
                            </div>
                        </form>
                        <div class="alert alert-info mt-3" id="demo-result">
                            Area: 2400
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
                            <svg id="demo-triangle-svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 300 225" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: #f8f9fa; border-radius: 0 0 5px 5px;">
                                <!-- Coordinate grid (optional) -->
                                <pattern id="grid" width="30" height="30" patternUnits="userSpaceOnUse">
                                    <path d="M 30 0 L 0 0 0 30" fill="none" stroke="#e0e0e0" stroke-width="0.5"/>
                                </pattern>
                                <rect width="100%" height="100%" fill="url(#grid)" />
                                
                                <!-- Triangle visualization -->
                                <polygon id="demo-triangle" points="150,50 100,200 200,200" fill="rgba(59, 89, 152, 0.2)" stroke="#3b5998" stroke-width="2" />
                                <line id="demo-height-line" x1="150" y1="50" x2="150" y2="200" stroke="red" stroke-width="2" stroke-dasharray="5,3" />
                                <line id="demo-base-line" x1="100" y1="200" x2="200" y2="200" stroke="red" stroke-width="2" />
                                
                                <!-- Measurement labels with better visibility -->
                                <g id="base-label">
                                    <rect x="35" y="-2" width="88" height="18" rx="5" fill="white" stroke="#3b5998" />
                                    <text id="demo-base-text" x="79" y="13" text-anchor="middle" fill="#3b5998" font-weight="bold">Base: 80</text>
                                </g>
                                
                                <g id="height-label">
                                    <rect x="35" y="-27" width="88" height="18" rx="5" fill="white" stroke="#3b5998" />
                                    <text id="demo-height-text" x="77" y="-12" text-anchor="middle" fill="#3b5998" font-weight="bold">Height: 60</text>
                                </g>
                                
                                <!-- Area label -->
                                <g id="area-label">
                                    <rect x="35" y="-62" width="88" height="24" rx="5" fill="#3b5998" stroke="#3b5998" />
                                    <text id="demo-area-text" x="79" y="-45" text-anchor="middle" fill="white" font-weight="bold">Area: 2400</text>
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

<!-- Add the custom JavaScript for the triangle demo -->
<script src="<?= JS_URL ?>/triangle-demo.js"></script>


<?php 
require_once(__DIR__ . '/../../layouts/foot.php');
?>