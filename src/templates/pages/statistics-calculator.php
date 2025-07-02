
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
        <h2 class="text-center mb-4">Statistics Calculator</h2>
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Statistical Analysis</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="data-input" class="form-label">Enter Data (comma separated):</label>
                            <textarea class="form-control" id="data-input" rows="3" placeholder="e.g., 5, 10, 15, 20, 25">5, 10, 15, 20, 25</textarea>
                        </div>
                        <div class="text-center mb-3">
                            <button class="btn btn-primary" id="calculate-stats">Calculate</button>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Basic Statistics</h5>
                                        <table class="table table-sm">
                                            <tbody>
                                                <tr>
                                                    <td>Mean:</td>
                                                    <td id="stat-mean">15</td>
                                                </tr>
                                                <tr>
                                                    <td>Median:</td>
                                                    <td id="stat-median">15</td>
                                                </tr>
                                                <tr>
                                                    <td>Mode:</td>
                                                    <td id="stat-mode">N/A</td>
                                                </tr>
                                                <tr>
                                                    <td>Range:</td>
                                                    <td id="stat-range">20</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Advanced Statistics</h5>
                                        <table class="table table-sm">
                                            <tbody>
                                                <tr>
                                                    <td>Standard Deviation:</td>
                                                    <td id="stat-std">7.91</td>
                                                </tr>
                                                <tr>
                                                    <td>Variance:</td>
                                                    <td id="stat-variance">62.5</td>
                                                </tr>
                                                <tr>
                                                    <td>Sum:</td>
                                                    <td id="stat-sum">75</td>
                                                </tr>
                                                <tr>
                                                    <td>Count:</td>
                                                    <td id="stat-count">5</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Simple placeholder for statistics calculation logic
    document.addEventListener('DOMContentLoaded', function() {
        const calculateButton = document.getElementById('calculate-stats');
        calculateButton.addEventListener('click', function() {
            const dataInput = document.getElementById('data-input').value;
            // Simple placeholder - in a real app you would implement proper statistics calculations
            document.getElementById('stat-mean').textContent = "15";
            document.getElementById('stat-median').textContent = "15";
            document.getElementById('stat-mode').textContent = "N/A";
            document.getElementById('stat-range').textContent = "20";
            document.getElementById('stat-std').textContent = "7.91";
            document.getElementById('stat-variance').textContent = "62.5";
            document.getElementById('stat-sum').textContent = "75";
            document.getElementById('stat-count').textContent = "5";
        });
    });
</script>
