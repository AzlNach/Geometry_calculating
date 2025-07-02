
<?php
// Only include the head if this is not an AJAX request
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
if (!$isAjax) {
    require_once(__DIR__ . '/../../config.php');
    require_once(TEMPLATES_DIR . '/layouts/head.php');
}
?>

<section class="demo-section mb-2">
    <div class="container">
        <h2 class="text-center mb-4">Geometry Calculations</h2>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Triangle Calculator</h3>
                    </div>
                    <div class="card-body text-center">
                        <img src="<?= IMAGES_URL ?>/segitiga.png" alt="Triangle Demo" class="img-fluid mb-3" style="height: 150px; object-fit: contain; background-color: #f8f9fa;">
                        <p>Calculate the area of a triangle and see it visualized in real-time.</p>
                        <a href="<?= BASE_URL ?>/triangle-demo.php" class="btn btn-outline-primary">Open Demo</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Square Calculator</h3>
                    </div>
                    <div class="card-body text-center">
                        <img src="<?= IMAGES_URL ?>/squre.png" alt="Square Demo" class="img-fluid mb-3" style="height: 150px; object-fit: contain; background-color: #f8f9fa;">
                        <p>Calculate area and perimeter of a square with interactive visualization.</p>
                        <a href="<?= BASE_URL ?>/square-demo.php" class="btn btn-outline-primary">Open Demo</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Circle Calculator</h3>
                    </div>
                    <div class="card-body text-center">
                        <img src="<?= IMAGES_URL ?>/circle.png" alt="Circle Demo" class="img-fluid mb-3" style="height: 150px; object-fit: contain; background-color: #f8f9fa;">
                        <p>Calculate area and circumference of a circle with interactive visualization.</p>
                        <a href="<?= BASE_URL ?>/circle-demo.php" class="btn btn-outline-primary">Open Demo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
