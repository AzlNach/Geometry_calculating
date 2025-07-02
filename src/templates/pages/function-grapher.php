
<?php
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
if (!$isAjax) {
    require_once(__DIR__ . '/../../config.php');
    require_once(TEMPLATES_DIR . '/layouts/head.php');
}
?>

<section class="demo-section mb-2">
    <div class="container">
        <h2 class="text-center mb-4">Function Grapher</h2>
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
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Range:</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="input-group">
                                        <span class="input-group-text">x min</span>
                                        <input type="number" class="form-control" id="x-min" value="-10">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        <span class="input-group-text">x max</span>
                                        <input type="number" class="form-control" id="x-max" value="10">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary" id="plot-function">Plot Function</button>
                        </div>
                        <div class="mt-4" style="height: 300px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px;">
                            <div id="function-graph" style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                <span class="text-muted">Graph will appear here</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add a placeholder for future function graphing logic -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const plotButton = document.getElementById('plot-function');
        plotButton.addEventListener('click', function() {
            document.getElementById('function-graph').innerHTML = 
                '<div class="alert alert-info">Function graphing will be implemented soon!</div>';
        });
    });
</script>
