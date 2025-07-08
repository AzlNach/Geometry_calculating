<?php


$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
if (!$isAjax) {
    require_once(__DIR__ . '/../../../config.php');
    require_once(TEMPLATES_DIR . '/layouts/head.php');
}
?>

<section class="demo-section mb-5">
    <div class="container">
        <h2 class="text-center mb-4">Basic Function Grapher</h2>
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Interactive Function Grapher</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="function-input" class="form-label">Function: f(x) =</label>
                            <input type="text" class="form-control" id="function-input" value="x^2" placeholder="e.g., x^2, sin(x), 2*x+3">
                            <div class="form-text">Supported functions: x^n, sin(x), cos(x), tan(x), log(x), exp(x), sqrt(x), abs(x)</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="x-min" class="form-label">X Range:</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" class="form-control" id="x-min" value="-10" placeholder="Min">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" class="form-control" id="x-max" value="10" placeholder="Max">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="y-min" class="form-label">Y Range:</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" class="form-control" id="y-min" value="-10" placeholder="Min">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" class="form-control" id="y-max" value="10" placeholder="Max">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mb-3">
                            <button class="btn btn-primary me-2" id="plot-function">Plot Function</button>
                            <button class="btn btn-outline-secondary" id="clear-graph">Clear Graph</button>
                        </div>
                        <div class="mt-4" style="height: 400px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; position: relative;">
                            <canvas id="function-canvas" style="width: 100%; height: 100%; border-radius: 4px;"></canvas>
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

<script src="<?= JS_URL ?>/function-grapher.js"></script>

<?php 
if (!$isAjax) {
    require_once(TEMPLATES_DIR . '/layouts/foot.php');
}
?>