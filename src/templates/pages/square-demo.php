
<?php 
require_once(__DIR__ . '/../layouts/head.php');
?>

<!-- Square Demo Section -->
<section class="demo-section mb-5">
    <div class="container">
        <h2 class="text-center mb-4">Square Calculator</h2>
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Square Calculator</h3>
                    </div>
                    <div class="card-body">
                        <form id="demo-square-form">
                            <div class="mb-3">
                                <label for="demo-side" class="form-label">Side Length:</label>
                                <input type="range" class="form-range" id="demo-side" min="10" max="150" value="50">
                                <div class="d-flex justify-content-between">
                                    <span>10</span>
                                    <span id="demo-side-value">50</span>
                                    <span>150</span>
                                </div>
                            </div>
                        </form>
                        <div class="alert alert-info mt-3" id="demo-square-area">
                            Area: 2500
                        </div>
                        <div class="alert alert-info mt-3" id="demo-square-perimeter">
                            Perimeter: 200
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
                            <svg id="demo-square-svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 300 225" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: #f8f9fa; border-radius: 0 0 5px 5px;">
                                <!-- Coordinate grid -->
                                <pattern id="grid-square" width="30" height="30" patternUnits="userSpaceOnUse">
                                    <path d="M 30 0 L 0 0 0 30" fill="none" stroke="#e0e0e0" stroke-width="0.5"/>
                                </pattern>
                                <rect width="100%" height="100%" fill="url(#grid-square)" />
                                
                                <!-- Square visualization -->
                                <rect id="demo-square" x="100" y="75" width="100" height="100" fill="rgba(59, 89, 152, 0.2)" stroke="#3b5998" stroke-width="2" />
                                
                                <!-- Measurement labels -->
                                <g id="side-label">
                                    <rect x="223" y="15" width="70" height="24" rx="5" fill="white" stroke="#3b5998" />
                                    <text id="demo-side-text" x="258" y="32" text-anchor="middle" fill="#3b5998" font-weight="bold">Side: 50</text>
                                </g>
                                
                                <g id="area-label-square">
                                    <rect x="10" y="15" width="89" height="24" rx="5" fill="#3b5998" stroke="#3b5998" />
                                    <text id="demo-area-square-text" x="55" y="32" text-anchor="middle" fill="white" font-weight="bold">Area: 2500</text>
                                </g>
                                
                                <g id="perimeter-label">
                                    <rect x="105" y="15" width="114" height="24" rx="5" fill="#3b5998" stroke="#3b5998" />
                                    <text id="demo-perimeter-text" x="161" y="32" text-anchor="middle" fill="white" font-weight="bold">Perimeter: 200</text>
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

<!-- Add the custom JavaScript for the square calculator -->
<script src="<?= JS_URL ?>/square.js"></script>

<?php 
require_once(__DIR__ . '/../layouts/foot.php');
?>