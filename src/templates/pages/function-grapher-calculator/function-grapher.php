<?php

// Only include the head if this is not an AJAX request
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
if (!$isAjax) {
    require_once(__DIR__ . '/../../../config.php');
    require_once(TEMPLATES_DIR . '/layouts/head.php');
}
?>

<section class="demo-section mb-2">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('function-canvas');
        const ctx = canvas.getContext('2d');
        const plotButton = document.getElementById('plot-function');
        const clearButton = document.getElementById('clear-graph');
        const functionInput = document.getElementById('function-input');
        const xMinInput = document.getElementById('x-min');
        const xMaxInput = document.getElementById('x-max');
        const yMinInput = document.getElementById('y-min');
        const yMaxInput = document.getElementById('y-max');
        
        // Debounce function for real-time updates
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
        
        // Set canvas size
        function resizeCanvas() {
            const rect = canvas.getBoundingClientRect();
            canvas.width = rect.width;
            canvas.height = rect.height;
            plotFunction(); // Re-plot when canvas is resized
        }
        
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);
        
        function clearCanvas() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            drawGrid();
        }
        
        function drawGrid() {
            const xMin = parseFloat(xMinInput.value);
            const xMax = parseFloat(xMaxInput.value);
            const yMin = parseFloat(yMinInput.value);
            const yMax = parseFloat(yMaxInput.value);
            
            ctx.strokeStyle = '#e0e0e0';
            ctx.lineWidth = 1;
            
            // Draw grid lines
            const gridSize = 20;
            for (let i = 0; i <= canvas.width; i += gridSize) {
                ctx.beginPath();
                ctx.moveTo(i, 0);
                ctx.lineTo(i, canvas.height);
                ctx.stroke();
            }
            
            for (let i = 0; i <= canvas.height; i += gridSize) {
                ctx.beginPath();
                ctx.moveTo(0, i);
                ctx.lineTo(canvas.width, i);
                ctx.stroke();
            }
            
            // Draw axes
            ctx.strokeStyle = '#666';
            ctx.lineWidth = 2;
            
            const centerX = canvas.width / 2;
            const centerY = canvas.height / 2;
            
            // Calculate axis positions based on ranges
            const xAxisY = canvas.height - ((0 - yMin) / (yMax - yMin)) * canvas.height;
            const yAxisX = ((0 - xMin) / (xMax - xMin)) * canvas.width;
            
            // X-axis
            ctx.beginPath();
            if (xAxisY >= 0 && xAxisY <= canvas.height) {
                ctx.moveTo(0, xAxisY);
                ctx.lineTo(canvas.width, xAxisY);
            } else {
                ctx.moveTo(0, centerY);
                ctx.lineTo(canvas.width, centerY);
            }
            ctx.stroke();
            
            // Y-axis
            ctx.beginPath();
            if (yAxisX >= 0 && yAxisX <= canvas.width) {
                ctx.moveTo(yAxisX, 0);
                ctx.lineTo(yAxisX, canvas.height);
            } else {
                ctx.moveTo(centerX, 0);
                ctx.lineTo(centerX, canvas.height);
            }
            ctx.stroke();
            
            // Draw coordinate labels
            drawCoordinateLabels(xMin, xMax, yMin, yMax, xAxisY, yAxisX);
        }
        
        function drawCoordinateLabels(xMin, xMax, yMin, yMax, xAxisY, yAxisX) {
            ctx.fillStyle = '#333';
            ctx.font = '12px Arial';
            
            // X-axis labels with integer step of 1 (FIXED TO MATCH Y-AXIS LOGIC)
            ctx.textAlign = 'center';
            ctx.textBaseline = 'top';
            
            const xStart = Math.ceil(xMin);
            const xEnd = Math.floor(xMax);
            
            for (let x = xStart; x <= xEnd; x += 1) {
                // Skip drawing label at x = 0 to avoid overlap with origin
                if (x === 0) continue;
                
                // FIXED: Use same coordinate calculation as Y-axis
                const canvasX = ((x - xMin) / (xMax - xMin)) * canvas.width;
                
                // Only draw if the position is within canvas bounds
                if (canvasX >= 0 && canvasX <= canvas.width) {
                    // FIXED: Ensure label position is properly constrained
                    const labelY = xAxisY >= 0 && xAxisY <= canvas.height 
                        ? Math.min(xAxisY + 15, canvas.height - 5)
                        : canvas.height / 2 + 15;
                    ctx.fillText(x.toString(), canvasX, labelY);
                }
            }
            
            // Y-axis labels with integer step of 1 (KEEP AS IS - WORKING CORRECTLY)
            ctx.textAlign = 'right';
            ctx.textBaseline = 'middle';
            
            const yStart = Math.ceil(yMin);
            const yEnd = Math.floor(yMax);
            
            for (let y = yStart; y <= yEnd; y += 1) {
                // Skip drawing label at y = 0 to avoid overlap with origin
                if (y === 0) continue;
                
                const canvasY = canvas.height - ((y - yMin) / (yMax - yMin)) * canvas.height;
                
                // Only draw if the position is within canvas bounds
                if (canvasY >= 0 && canvasY <= canvas.height) {
                    const labelX = yAxisX >= 0 && yAxisX <= canvas.width 
                        ? Math.max(yAxisX - 5, 30)
                        : Math.max(canvas.width / 2 - 5, 30);
                    ctx.fillText(y.toString(), labelX, canvasY);
                }
            }
            
            // Draw origin label (0) only once, positioned carefully to avoid overlap
            if (yAxisX >= 0 && yAxisX <= canvas.width && xAxisY >= 0 && xAxisY <= canvas.height) {
                ctx.textAlign = 'right';
                ctx.textBaseline = 'top';
                ctx.fillText('0', yAxisX - 5, xAxisY + 5);
            }
        }
        
        function plotFunction() {
            const functionInputValue = functionInput.value.trim();
            const xMin = parseFloat(xMinInput.value);
            const xMax = parseFloat(xMaxInput.value);
            const yMin = parseFloat(yMinInput.value);
            const yMax = parseFloat(yMaxInput.value);
            
            // Validate inputs
            if (!functionInputValue || isNaN(xMin) || isNaN(xMax) || isNaN(yMin) || isNaN(yMax)) {
                clearCanvas();
                return;
            }
            
            if (xMin >= xMax || yMin >= yMax) {
                clearCanvas();
                return;
            }
            
            clearCanvas();
            
            // Simple function parser (basic implementation)
            function evaluateFunction(x, func) {
                try {
                    // Replace common mathematical functions
                    let expression = func.replace(/\^/g, '**')
                                        .replace(/sin/g, 'Math.sin')
                                        .replace(/cos/g, 'Math.cos')
                                        .replace(/tan/g, 'Math.tan')
                                        .replace(/log/g, 'Math.log')
                                        .replace(/exp/g, 'Math.exp')
                                        .replace(/sqrt/g, 'Math.sqrt')
                                        .replace(/abs/g, 'Math.abs')
                                        .replace(/pi/g, 'Math.PI')
                                        .replace(/e/g, 'Math.E')
                                        .replace(/x/g, `(${x})`);
                    
                    return eval(expression);
                } catch (e) {
                    return NaN;
                }
            }
            
            // Plot the function
            ctx.strokeStyle = '#3b5998';
            ctx.lineWidth = 3;
            ctx.beginPath();
            
            let firstPoint = true;
            const step = (xMax - xMin) / (canvas.width * 2); // More resolution for smoother curves
            
            for (let x = xMin; x <= xMax; x += step) {
                const y = evaluateFunction(x, functionInputValue);
                
                if (!isNaN(y) && isFinite(y) && y >= yMin && y <= yMax) {
                    // Convert to canvas coordinates
                    const canvasX = ((x - xMin) / (xMax - xMin)) * canvas.width;
                    const canvasY = canvas.height - ((y - yMin) / (yMax - yMin)) * canvas.height;
                    
                    if (firstPoint) {
                        ctx.moveTo(canvasX, canvasY);
                        firstPoint = false;
                    } else {
                        ctx.lineTo(canvasX, canvasY);
                    }
                }
            }
            
            ctx.stroke();
        }
        
        // Debounced version for real-time updates
        const debouncedPlotFunction = debounce(plotFunction, 300);
        
        // Event listeners for real-time updates
        functionInput.addEventListener('input', debouncedPlotFunction);
        xMinInput.addEventListener('input', debouncedPlotFunction);
        xMaxInput.addEventListener('input', debouncedPlotFunction);
        yMinInput.addEventListener('input', debouncedPlotFunction);
        yMaxInput.addEventListener('input', debouncedPlotFunction);
        
        // Manual plot button
        plotButton.addEventListener('click', plotFunction);
        clearButton.addEventListener('click', clearCanvas);
        
        // Initialize with default plot
        clearCanvas();
        plotFunction();
    });
</script>

<?php 
if (!$isAjax) {
    require_once(TEMPLATES_DIR . '/layouts/foot.php');
}
?>