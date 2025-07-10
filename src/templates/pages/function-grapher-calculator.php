<?php
// Only include the head if this is not an AJAX request
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
if (!$isAjax) {
    require_once(__DIR__ . '/../../config.php');
    require_once(TEMPLATES_DIR . '/layouts/head.php');
}
?>

<section class="demo-section mb-5">
    <div class="container">
        <h2 class="text-center mb-4">Function Grapher Calculator</h2>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Basic Function Grapher</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3 mx-auto" style="width: 80px; height: 80px; background-color: #f8f9fa; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">show_chart</span>
                        </div>
                        <p>Plot polynomial, trigonometric, and exponential functions with customizable ranges.</p>
                        <a href="<?= BASE_URL ?>/function-grapher" class="btn btn-outline-primary">Open Demo</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Parametric Function Grapher</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3 mx-auto" style="width: 80px; height: 80px; background-color: #f8f9fa; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">multiline_chart</span>
                        </div>
                        <p>Plot parametric functions x(t) and y(t) to create curves and complex shapes.</p>
                        <a href="<?= BASE_URL ?>/parametric-grapher" class="btn btn-outline-primary">Open Demo</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Polar Function Grapher</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3 mx-auto" style="width: 80px; height: 80px; background-color: #f8f9fa; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">donut_large</span>
                        </div>
                        <p>Visualize polar functions r(θ) to create spirals, roses, and other polar curves.</p>
                        <a href="<?= BASE_URL ?>/polar-grapher" class="btn btn-outline-primary">Open Demo</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">3D Function Grapher</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3 mx-auto" style="width: 80px; height: 80px; background-color: #f8f9fa; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">view_in_ar</span>
                        </div>
                        <p>Plot 3D functions z(x,y) with interactive rotation and zoom capabilities.</p>
                        <a href="<?= BASE_URL ?>/3d-function-grapher" class="btn btn-outline-primary">Open Demo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
if (!$isAjax) {
    require_once(TEMPLATES_DIR . '/layouts/foot.php');
}
?>