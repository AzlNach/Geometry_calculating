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
        <h2 class="text-center mb-4">Statistics Calculator</h2>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Input & Manage Data</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3 mx-auto" style="width: 80px; height: 80px; background-color: #f8f9fa; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">straighten</span>
                        </div>
                        <p>Input your data points, and the calculator will automatically calculate the mean, median, mode, range, standard deviation, variance, sum, and count.</p>
                        <a href="<?= BASE_URL ?>/data_management" class="btn btn-outline-primary">Open Demo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>