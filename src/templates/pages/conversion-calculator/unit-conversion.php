
<?php
// Only include the head if this is not an AJAX request
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
if (!$isAjax) {
    require_once(__DIR__ . '/../../../config.php');
    require_once(TEMPLATES_DIR . '/layouts/head.php');
}
?>

<section class="demo-section mb-5">
    <div class="container">
        <h2 class="text-center mb-4">Unit Conversion</h2>
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Unit Converter</h3>
                    </div>
                    <div class="card-body">
                        <form id="unit-converter-form">
                            <div class="mb-3">
                                <label for="conversion-type" class="form-label">Conversion Type:</label>
                                <select class="form-select" id="conversion-type">
                                    <option value="length">Length</option>
                                    <option value="area">Area</option>
                                    <option value="volume">Volume</option>
                                    <option value="weight">Weight</option>
                                </select>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-5">
                                    <label for="from-value" class="form-label">From:</label>
                                    <input type="number" class="form-control" id="from-value" value="1">
                                </div>
                                <div class="col-md-3">
                                    <label for="from-unit" class="form-label">Unit:</label>
                                    <select class="form-select" id="from-unit">
                                        <!-- Will be populated by JS -->
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="to-unit" class="form-label">To Unit:</label>
                                    <select class="form-select" id="to-unit">
                                        <!-- Will be populated by JS -->
                                    </select>
                                </div>
                            </div>
                            <div class="alert alert-info" id="conversion-result">
                                Result: 100 cm
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="<?= BASE_URL ?>/index.php" class="btn btn-outline-primary">Back to Home</a>
        </div>
    </div>
</section>

<!-- Add the custom JavaScript for the unit converter -->
<script src="<?= JS_URL ?>/unit-conversion.js"></script>

<?php 
if (!$isAjax) {
    require_once(TEMPLATES_DIR . '/layouts/foot.php');
}
?>