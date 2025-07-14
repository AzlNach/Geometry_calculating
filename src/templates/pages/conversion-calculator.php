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
        <h2 class="text-center mb-4">Conversion Calculator</h2>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Unit Conversion</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3 mx-auto" style="width: 80px; height: 80px; background-color: #f8f9fa; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">straighten</span>
                        </div>
                        <p>Convert between different units of length, area, volume, and weight measurements.</p>
                        <a href="<?= BASE_URL ?>/unit-conversion" class="btn btn-outline-primary">Open Demo</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Digital Data Converter</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3 mx-auto" style="width: 80px; height: 80px; background-color: #f8f9fa; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">storage</span>
                        </div>
                        <p>Convert digital data units like bytes, kilobytes, megabytes, gigabytes, and terabytes.</p>
                        <a href="<?= BASE_URL ?>/digital-data-converter" class="btn btn-outline-primary">Open Demo</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Temperature Converter</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3 mx-auto" style="width: 80px; height: 80px; background-color: #f8f9fa; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">thermostat</span>
                        </div>
                        <p>Convert temperatures between Celsius, Fahrenheit, Kelvin, and Rankine scales.</p>
                        <a href="<?= BASE_URL ?>/temperature-converter" class="btn btn-outline-primary">Open Demo</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Time Converter</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3 mx-auto" style="width: 80px; height: 80px; background-color: #f8f9fa; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <span class="material-symbols-rounded" style="font-size: 48px; color: #3b5998;">schedule</span>
                        </div>
                        <p>Convert time units between seconds, minutes, hours, days, weeks, months, and years.</p>
                        <a href="<?= BASE_URL ?>/time-converter" class="btn btn-outline-primary">Open Demo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>