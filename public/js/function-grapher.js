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


    function resizeCanvas() {
        const rect = canvas.getBoundingClientRect();
        canvas.width = rect.width;
        canvas.height = rect.height;
        plotFunction();
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


        ctx.strokeStyle = '#666';
        ctx.lineWidth = 2;

        const centerX = canvas.width / 2;
        const centerY = canvas.height / 2;


        const xAxisY = canvas.height - ((0 - yMin) / (yMax - yMin)) * canvas.height;
        const yAxisX = ((0 - xMin) / (xMax - xMin)) * canvas.width;


        ctx.beginPath();
        if (xAxisY >= 0 && xAxisY <= canvas.height) {
            ctx.moveTo(0, xAxisY);
            ctx.lineTo(canvas.width, xAxisY);
        } else {
            ctx.moveTo(0, centerY);
            ctx.lineTo(canvas.width, centerY);
        }
        ctx.stroke();


        ctx.beginPath();
        if (yAxisX >= 0 && yAxisX <= canvas.width) {
            ctx.moveTo(yAxisX, 0);
            ctx.lineTo(yAxisX, canvas.height);
        } else {
            ctx.moveTo(centerX, 0);
            ctx.lineTo(centerX, canvas.height);
        }
        ctx.stroke();


        drawCoordinateLabels(xMin, xMax, yMin, yMax, xAxisY, yAxisX);
    }

    function drawCoordinateLabels(xMin, xMax, yMin, yMax, xAxisY, yAxisX) {
        ctx.fillStyle = '#333';
        ctx.font = '12px Arial';


        ctx.textAlign = 'center';
        ctx.textBaseline = 'top';

        const xStart = Math.ceil(xMin);
        const xEnd = Math.floor(xMax);

        for (let x = xStart; x <= xEnd; x += 1) {

            if (x === 0) continue;


            const canvasX = ((x - xMin) / (xMax - xMin)) * canvas.width;


            if (canvasX >= 0 && canvasX <= canvas.width) {

                const labelY = xAxisY >= 0 && xAxisY <= canvas.height ?
                    Math.min(xAxisY + 15, canvas.height - 5) :
                    canvas.height / 2 + 15;
                ctx.fillText(x.toString(), canvasX, labelY);
            }
        }


        ctx.textAlign = 'right';
        ctx.textBaseline = 'middle';

        const yStart = Math.ceil(yMin);
        const yEnd = Math.floor(yMax);

        for (let y = yStart; y <= yEnd; y += 1) {

            if (y === 0) continue;

            const canvasY = canvas.height - ((y - yMin) / (yMax - yMin)) * canvas.height;


            if (canvasY >= 0 && canvasY <= canvas.height) {
                const labelX = yAxisX >= 0 && yAxisX <= canvas.width ?
                    Math.max(yAxisX - 5, 30) :
                    Math.max(canvas.width / 2 - 5, 30);
                ctx.fillText(y.toString(), labelX, canvasY);
            }
        }


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


        if (!functionInputValue || isNaN(xMin) || isNaN(xMax) || isNaN(yMin) || isNaN(yMax)) {
            clearCanvas();
            return;
        }

        if (xMin >= xMax || yMin >= yMax) {
            clearCanvas();
            return;
        }

        clearCanvas();


        function evaluateFunction(x, func) {
            try {

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


        ctx.strokeStyle = '#3b5998';
        ctx.lineWidth = 3;
        ctx.beginPath();

        let firstPoint = true;
        const step = (xMax - xMin) / (canvas.width * 2);

        for (let x = xMin; x <= xMax; x += step) {
            const y = evaluateFunction(x, functionInputValue);

            if (!isNaN(y) && isFinite(y) && y >= yMin && y <= yMax) {

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


    const debouncedPlotFunction = debounce(plotFunction, 300);


    functionInput.addEventListener('input', debouncedPlotFunction);
    xMinInput.addEventListener('input', debouncedPlotFunction);
    xMaxInput.addEventListener('input', debouncedPlotFunction);
    yMinInput.addEventListener('input', debouncedPlotFunction);
    yMaxInput.addEventListener('input', debouncedPlotFunction);


    plotButton.addEventListener('click', plotFunction);
    clearButton.addEventListener('click', clearCanvas);


    clearCanvas();
    plotFunction();
});