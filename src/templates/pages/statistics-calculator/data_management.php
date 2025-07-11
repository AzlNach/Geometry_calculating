<?php

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
if (!$isAjax) {
    require_once(__DIR__ . '/../../../config.php');
    require_once(TEMPLATES_DIR . '/layouts/head.php');
}
?>

<section class="demo-section mb-5">
    <div class="container">
        <h2 class="text-center mb-4">Statistical Analysis Platform</h2>
        
        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs justify-content-center mb-4" id="analysisTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="data-tab" data-bs-toggle="tab" data-bs-target="#data-panel" type="button" role="tab">
                    <i class="fas fa-database"></i> Enter Data
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="descriptive-tab" data-bs-toggle="tab" data-bs-target="#descriptive-panel" type="button" role="tab">
                    <i class="fas fa-chart-bar"></i> Descriptive Statistics
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="visualization-tab" data-bs-toggle="tab" data-bs-target="#visualization-panel" type="button" role="tab">
                    <i class="fas fa-chart-line"></i> Data Visualization
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="inferential-tab" data-bs-toggle="tab" data-bs-target="#inferential-panel" type="button" role="tab">
                    <i class="fas fa-calculator"></i> Inferential Statistics
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="analysisTabContent">
            
            <!-- Enter Data Tab -->
            <div class="tab-pane fade show active" id="data-panel" role="tabpanel">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h3 class="card-title mb-0">Input & Manage Data</h3>
                            </div>
                            <div class="card-body">
                                <!-- Data Input Methods -->
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="card h-100">
                                            <div class="card-body text-center">
                                                <i class="fas fa-keyboard fa-3x text-primary mb-3"></i>
                                                <h5>Manual Input</h5>
                                                <p class="text-muted">Type or paste data directly</p>
                                                <button class="btn btn-primary" id="manual-input-btn">Start Input</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card h-100">
                                            <div class="card-body text-center">
                                                <i class="fas fa-upload fa-3x text-success mb-3"></i>
                                                <h5>Import Data</h5>
                                                <p class="text-muted">Upload CSV or Excel files</p>
                                                <input type="file" id="file-input" accept=".csv,.xlsx,.xls" style="display: none;">
                                                <button class="btn btn-success" id="import-btn">Import File</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card h-100">
                                            <div class="card-body text-center">
                                                <i class="fas fa-folder-open fa-3x text-info mb-3"></i>
                                                <h5>My Data</h5>
                                                <p class="text-muted">View saved datasets</p>
                                                <button class="btn btn-info" id="my-data-btn">View Data</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Manual Input Section -->
                                <div id="manual-input-section" class="mb-4" style="display: none;">
                                    <div class="mb-3">
                                        <label for="dataset-name" class="form-label">Dataset Name:</label>
                                        <input type="text" class="form-control" id="dataset-name" placeholder="Enter dataset name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="data-input" class="form-label">Enter Data (comma separated):</label>
                                        <textarea class="form-control" id="data-input" rows="4" placeholder="e.g., 5, 10, 15, 20, 25"></textarea>
                                    </div>
                                    <div class="text-center">
                                        <button class="btn btn-primary" id="save-data-btn">Save Data</button>
                                        <button class="btn btn-secondary" id="cancel-input-btn">Cancel</button>
                                    </div>
                                </div>

                                <!-- File Import Section -->
                                <div id="file-import-section" class="mb-4" style="display: none;">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> Supported formats: CSV, XLSX, XLS
                                    </div>
                                    <div id="file-preview"></div>
                                </div>

                                <!-- My Data Section -->
                                <div id="my-data-section" style="display: none;">
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="datasets-table">
                                            <thead>
                                                <tr>
                                                    <th>Dataset Name</th>
                                                    <th>Data Preview</th>
                                                    <th>Count</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="datasets-tbody">
                                                <!-- Datasets will be populated here -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Descriptive Statistics Tab -->
            <div class="tab-pane fade" id="descriptive-panel" role="tabpanel">
                <div class="row">
                    <div class="col-lg-10 mx-auto h-100">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h3 class="card-title mb-0">Descriptive Statistics</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="dataset-select" class="form-label">Select Dataset:</label>
                                    <select class="form-select" id="dataset-select">
                                        <option value="">Choose a dataset...</option>
                                    </select>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3 mb-3">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h5 class="card-body text-center">Measures of Central Tendency</h5>
                                                <table class="table table-sm">
                                                    <tbody>
                                                        <tr><td>Mean:</td><td id="stat-mean">-</td></tr>
                                                        <tr><td>Median:</td><td id="stat-median">-</td></tr>
                                                        <tr><td>Mode:</td><td id="stat-mode">-</td></tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h5 class="card-body text-center">Measures of Spread</h5>
                                                <table class="table table-sm">
                                                    <tbody>
                                                        <tr><td>Range:</td><td id="stat-range">-</td></tr>
                                                        <tr><td>Variance:</td><td id="stat-variance">-</td></tr>
                                                        <tr><td>Standard Deviation:</td><td id="stat-std">-</td></tr>
                                                        <tr><td>IQR:</td><td id="stat-iqr">-</td></tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-body text-center">Quartiles</h5>
                                                <table class="table table-sm">
                                                    <tbody>
                                                        <tr><td>Q1 (25th percentile):</td><td id="stat-q1">-</td></tr>
                                                        <tr><td>Q2 (50th percentile):</td><td id="stat-q2">-</td></tr>
                                                        <tr><td>Q3 (75th percentile):</td><td id="stat-q3">-</td></tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-body text-center">Summary</h5>
                                                <table class="table table-sm">
                                                    <tbody>
                                                        <tr><td>Count:</td><td id="stat-count">-</td></tr>
                                                        <tr><td>Sum:</td><td id="stat-sum">-</td></tr>
                                                        <tr><td>Min:</td><td id="stat-min">-</td></tr>
                                                        <tr><td>Max:</td><td id="stat-max">-</td></tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right mt-3">
                                    <button class="btn btn-outline-success" id="export-stats">Export Results</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Visualization Tab -->
            <div class="tab-pane fade" id="visualization-panel" role="tabpanel">
                <div class="row">
                    <div class="col-lg-10 mx-auto h-100">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h3 class="card-title mb-0">Data Visualization</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3">
                                        <label for="viz-dataset-select" class="form-label">Select Dataset:</label>
                                        <select class="form-select" id="viz-dataset-select">
                                            <option value="">Choose a dataset...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="chart-type-select" class="form-label">Chart Type:</label>
                                        <select class="form-select" id="chart-type-select">
                                            <option value="histogram">Histogram</option>
                                            <option value="bar">Bar Chart</option>
                                            <option value="pie">Pie Chart</option>
                                            <option value="scatter">Scatter Plot</option>
                                            <option value="line">Line Chart</option>
                                            <option value="box">Box Plot</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="card">
                                    <div class="card-body">
                                        <canvas id="data-chart" width="800" height="400"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inferential Statistics Tab -->
            <div class="tab-pane fade" id="inferential-panel" role="tabpanel">
                <div class="row">
                    <div class="col-lg-10 mx-auto h-100">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h3 class="card-title mb-0">Inferential Statistics</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h5 class="card-body text-center">Correlation Analysis</h5>
                                                <div class="mb-3">
                                                    <label class="form-label">Select Datasets:</label>
                                                    <select class="form-select mb-2" id="correlation-dataset1">
                                                        <option value="">Dataset 1...</option>
                                                    </select>
                                                    <select class="form-select" id="correlation-dataset2">
                                                        <option value="">Dataset 2...</option>
                                                    </select>
                                                </div>
                                                <button class="btn btn-primary" id="calculate-correlation">Calculate Correlation</button>
                                                <div id="correlation-results" class="mt-3"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h5 class="card-body text-center">Hypothesis Testing</h5>
                                                <div class="mb-3">
                                                    <label class="form-label">Test Type:</label>
                                                    <select class="form-select" id="hypothesis-test-type">
                                                        <option value="ttest">t-Test</option>
                                                        <option value="anova">ANOVA</option>
                                                        <option value="chisquare">Chi-Square</option>
                                                    </select>
                                                </div>
                                                <button class="btn btn-primary" id="run-hypothesis-test">Run Test</button>
                                                <div id="hypothesis-results" class="mt-3"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-body text-center">Regression Analysis</h5>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Independent Variable (X):</label>
                                                <select class="form-select" id="regression-x">
                                                    <option value="">Select dataset...</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Dependent Variable (Y):</label>
                                                <select class="form-select" id="regression-y">
                                                    <option value="">Select dataset...</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="text-center mt-3">
                                            <button class="btn btn-primary" id="run-regression">Run Linear Regression</button>
                                        </div>
                                        <div id="regression-results" class="mt-3"></div>
                                    </div>
                                </div>
                            </div>
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

<!-- Include Chart.js for visualizations -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<!-- Include PapaParse for CSV parsing -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.4.1/papaparse.min.js"></script>
<!-- Include SheetJS for Excel parsing -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<!-- Include our custom JavaScript -->
<script src="<?= JS_URL ?>/data_management.js"></script>

<?php 
if (!$isAjax) {
    require_once(TEMPLATES_DIR . '/layouts/foot.php');
}
?>