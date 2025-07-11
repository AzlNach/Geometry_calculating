/**
 * Statistical Analysis Platform - JavaScript Implementation
 * Handles data management, descriptive statistics, visualization, and inferential statistics
 */

class StatisticsCalculator {
    constructor() {
        this.datasets = new Map();
        this.chart = null;
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadDatasets();
        this.populateDatasetSelects();
    }

    bindEvents() {
        // Data Input Events
        document.getElementById('manual-input-btn').addEventListener('click', () => this.showManualInput());
        document.getElementById('import-btn').addEventListener('click', () => this.showFileImport());
        document.getElementById('my-data-btn').addEventListener('click', () => this.showMyData());
        document.getElementById('save-data-btn').addEventListener('click', () => this.saveData());
        document.getElementById('cancel-input-btn').addEventListener('click', () => this.hideManualInput());
        document.getElementById('file-input').addEventListener('change', (e) => this.handleFileImport(e));

        // Statistics Events
        document.getElementById('export-stats').addEventListener('click', () => this.exportStatistics());
        document.getElementById('dataset-select').addEventListener('change', () => this.calculateStatistics());

        // Visualization Events

        document.getElementById('viz-dataset-select').addEventListener('change', () => this.generateChart());
        document.getElementById('chart-type-select').addEventListener('change', () => this.generateChart());

        // Inferential Statistics Events
        document.getElementById('calculate-correlation').addEventListener('click', () => this.calculateCorrelation());
        document.getElementById('run-hypothesis-test').addEventListener('click', () => this.runHypothesisTest());
        document.getElementById('run-regression').addEventListener('click', () => this.runRegression());

        // Tab switching events
        document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
            tab.addEventListener('shown.bs.tab', (e) => this.onTabSwitch(e.target));
        });
    }

    onTabSwitch(tab) {
        const targetTab = tab.getAttribute('data-bs-target');

        if (targetTab === '#descriptive-panel') {
            this.populateDatasetSelects();
        } else if (targetTab === '#visualization-panel') {
            this.populateDatasetSelects();
        } else if (targetTab === '#inferential-panel') {
            this.populateDatasetSelects();
        }
    }

    // ==================== DATA MANAGEMENT ====================

    showManualInput() {
        document.getElementById('manual-input-section').style.display = 'block';
        document.getElementById('file-import-section').style.display = 'none';
        document.getElementById('my-data-section').style.display = 'none';
    }

    showFileImport() {
        document.getElementById('file-input').click();
    }

    showMyData() {
        document.getElementById('manual-input-section').style.display = 'none';
        document.getElementById('file-import-section').style.display = 'none';
        document.getElementById('my-data-section').style.display = 'block';
        this.displayDatasets();
    }

    hideManualInput() {
        document.getElementById('manual-input-section').style.display = 'none';
        document.getElementById('dataset-name').value = '';
        document.getElementById('data-input').value = '';
    }

    saveData() {
        const name = document.getElementById('dataset-name').value.trim();
        const dataInput = document.getElementById('data-input').value.trim();

        if (!name || !dataInput) {
            this.showAlert('Please enter both dataset name and data.', 'warning');
            return;
        }

        try {
            const data = this.parseDataInput(dataInput);
            this.datasets.set(name, data);
            this.saveDatasets();
            this.populateDatasetSelects();
            this.hideManualInput();
            this.showAlert(`Dataset "${name}" saved successfully with ${data.length} data points!`, 'success');
        } catch (error) {
            this.showAlert('Error parsing data: ' + error.message, 'danger');
        }
    }

    parseDataInput(input) {
        const data = input.split(/[,\n\t\s]+/)
            .map(item => item.trim())
            .filter(item => item !== '')
            .map(item => {
                const num = parseFloat(item);
                if (isNaN(num)) throw new Error(`Invalid number: ${item}`);
                return num;
            });

        if (data.length === 0) throw new Error('No valid numbers found');
        return data;
    }

    handleFileImport(event) {
        const file = event.target.files[0];
        if (!file) return;

        const fileExtension = file.name.split('.').pop().toLowerCase();

        if (fileExtension === 'csv') {
            this.parseCsvFile(file);
        } else if (['xlsx', 'xls'].includes(fileExtension)) {
            this.parseExcelFile(file);
        } else {
            this.showAlert('Unsupported file format. Please use CSV or Excel files.', 'danger');
        }
    }

    parseCsvFile(file) {
        Papa.parse(file, {
            complete: (results) => {
                try {
                    const data = this.extractNumericData(results.data);
                    const name = file.name.replace(/\.[^/.]+$/, "");
                    this.datasets.set(name, data);
                    this.saveDatasets();
                    this.populateDatasetSelects();
                    this.showFilePreview(name, data);
                } catch (error) {
                    this.showAlert('Error parsing CSV: ' + error.message, 'danger');
                }
            },
            header: true,
            skipEmptyLines: true,
            error: (error) => {
                this.showAlert('Error reading CSV file: ' + error.message, 'danger');
            }
        });
    }

    parseExcelFile(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            try {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: 'array' });
                const sheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[sheetName];
                const jsonData = XLSX.utils.sheet_to_json(worksheet);

                const numericData = this.extractNumericData(jsonData);
                const name = file.name.replace(/\.[^/.]+$/, "");
                this.datasets.set(name, numericData);
                this.saveDatasets();
                this.populateDatasetSelects();
                this.showFilePreview(name, numericData);
            } catch (error) {
                this.showAlert('Error parsing Excel file: ' + error.message, 'danger');
            }
        };
        reader.onerror = () => {
            this.showAlert('Error reading Excel file.', 'danger');
        };
        reader.readAsArrayBuffer(file);
    }

    extractNumericData(data) {
        const numbers = [];

        if (Array.isArray(data)) {
            data.forEach(row => {
                if (typeof row === 'object' && row !== null) {
                    Object.values(row).forEach(value => {
                        const num = parseFloat(value);
                        if (!isNaN(num)) numbers.push(num);
                    });
                } else {
                    const num = parseFloat(row);
                    if (!isNaN(num)) numbers.push(num);
                }
            });
        }

        if (numbers.length === 0) throw new Error('No numeric data found in file');
        return numbers;
    }

    showFilePreview(name, data) {
        document.getElementById('file-import-section').style.display = 'block';
        const preview = document.getElementById('file-preview');
        preview.innerHTML = `
            <div class="alert alert-success">
                <h5><i class="fas fa-check-circle"></i> File imported successfully!</h5>
                <p><strong>Dataset:</strong> ${name}</p>
                <p><strong>Data points:</strong> ${data.length}</p>
                <p><strong>Preview:</strong> ${data.slice(0, 10).join(', ')}${data.length > 10 ? '...' : ''}</p>
            </div>
        `;
    }

    displayDatasets() {
        const tbody = document.getElementById('datasets-tbody');
        tbody.innerHTML = '';

        if (this.datasets.size === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        <i class="fas fa-inbox"></i> No datasets available
                    </td>
                </tr>
            `;
            return;
        }

        this.datasets.forEach((data, name) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><strong>${name}</strong></td>
                <td>${data.slice(0, 5).join(', ')}${data.length > 5 ? '...' : ''}</td>
                <td><span class="badge bg-primary">${data.length}</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" onclick="statsCalc.editDataset('${name}')">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-outline-danger ms-1" onclick="statsCalc.deleteDataset('${name}')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    editDataset(name) {
        const data = this.datasets.get(name);
        if (data) {
            document.getElementById('dataset-name').value = name;
            document.getElementById('data-input').value = data.join(', ');
            this.showManualInput();
        }
    }

    deleteDataset(name) {
        if (confirm(`Are you sure you want to delete dataset "${name}"?`)) {
            this.datasets.delete(name);
            this.saveDatasets();
            this.populateDatasetSelects();
            this.displayDatasets();
            this.showAlert(`Dataset "${name}" deleted successfully.`, 'info');
        }
    }

    populateDatasetSelects() {
        const selects = [
            'dataset-select',
            'viz-dataset-select',
            'correlation-dataset1',
            'correlation-dataset2',
            'regression-x',
            'regression-y'
        ];

        selects.forEach(selectId => {
            const select = document.getElementById(selectId);
            if (!select) return;

            const currentValue = select.value;
            select.innerHTML = '<option value="">Choose a dataset...</option>';

            this.datasets.forEach((data, name) => {
                const option = document.createElement('option');
                option.value = name;
                option.textContent = `${name} (${data.length} points)`;
                if (name === currentValue) option.selected = true;
                select.appendChild(option);
            });
        });
    }

    saveDatasets() {
        const datasetsObj = {};
        this.datasets.forEach((data, name) => {
            datasetsObj[name] = data;
        });
        localStorage.setItem('statisticsDatasets', JSON.stringify(datasetsObj));
    }

    loadDatasets() {
        try {
            const stored = localStorage.getItem('statisticsDatasets');
            if (stored) {
                const datasetsObj = JSON.parse(stored);
                this.datasets = new Map(Object.entries(datasetsObj));
            }
        } catch (error) {
            console.error('Error loading datasets:', error);
            this.datasets = new Map();
        }
    }

    // ==================== DESCRIPTIVE STATISTICS ====================

    calculateStatistics() {
        const selectedDataset = document.getElementById('dataset-select').value;
        if (!selectedDataset) {
            this.clearStatistics();
            return;
        }

        const data = this.datasets.get(selectedDataset);
        if (!data) {
            this.clearStatistics();
            return;
        }

        const stats = this.computeDescriptiveStats(data);
        this.displayStatistics(stats);
    }

    computeDescriptiveStats(data) {
        const sorted = [...data].sort((a, b) => a - b);
        const n = data.length;
        const sum = data.reduce((a, b) => a + b, 0);
        const mean = sum / n;

        // Median
        const median = n % 2 === 0 ?
            (sorted[n / 2 - 1] + sorted[n / 2]) / 2 :
            sorted[Math.floor(n / 2)];

        // Mode
        const frequency = {};
        data.forEach(val => frequency[val] = (frequency[val] || 0) + 1);
        const maxFreq = Math.max(...Object.values(frequency));
        const modes = Object.keys(frequency).filter(key => frequency[key] === maxFreq);
        const mode = modes.length === data.length ? 'No mode' : modes.join(', ');

        // Variance and Standard Deviation
        const variance = data.reduce((sum, val) => sum + Math.pow(val - mean, 2), 0) / n;
        const stdDev = Math.sqrt(variance);

        // Quartiles
        const q1 = this.percentile(sorted, 25);
        const q2 = median;
        const q3 = this.percentile(sorted, 75);
        const iqr = q3 - q1;

        // Range
        const range = sorted[n - 1] - sorted[0];

        return {
            mean: mean.toFixed(2),
            median: median.toFixed(2),
            mode: mode,
            variance: variance.toFixed(2),
            stdDev: stdDev.toFixed(2),
            range: range.toFixed(2),
            iqr: iqr.toFixed(2),
            q1: q1.toFixed(2),
            q2: q2.toFixed(2),
            q3: q3.toFixed(2),
            count: n,
            sum: sum.toFixed(2),
            min: sorted[0].toFixed(2),
            max: sorted[n - 1].toFixed(2)
        };
    }

    percentile(sortedData, p) {
        const index = (p / 100) * (sortedData.length - 1);
        const lower = Math.floor(index);
        const upper = Math.ceil(index);
        const weight = index - lower;

        if (lower === upper) {
            return sortedData[lower];
        }

        return sortedData[lower] * (1 - weight) + sortedData[upper] * weight;
    }

    displayStatistics(stats) {
        const elements = {
            'stat-mean': stats.mean,
            'stat-median': stats.median,
            'stat-mode': stats.mode,
            'stat-variance': stats.variance,
            'stat-std': stats.stdDev,
            'stat-range': stats.range,
            'stat-iqr': stats.iqr,
            'stat-q1': stats.q1,
            'stat-q2': stats.q2,
            'stat-q3': stats.q3,
            'stat-count': stats.count,
            'stat-sum': stats.sum,
            'stat-min': stats.min,
            'stat-max': stats.max
        };

        Object.entries(elements).forEach(([id, value]) => {
            const element = document.getElementById(id);
            if (element) element.textContent = value;
        });
    }

    clearStatistics() {
        const elements = [
            'stat-mean', 'stat-median', 'stat-mode', 'stat-variance', 'stat-std',
            'stat-range', 'stat-iqr', 'stat-q1', 'stat-q2', 'stat-q3',
            'stat-count', 'stat-sum', 'stat-min', 'stat-max'
        ];

        elements.forEach(id => {
            const element = document.getElementById(id);
            if (element) element.textContent = '-';
        });
    }

    exportStatistics() {
        const selectedDataset = document.getElementById('dataset-select').value;
        if (!selectedDataset) {
            this.showAlert('Please select a dataset first.', 'warning');
            return;
        }

        const data = this.datasets.get(selectedDataset);
        const stats = this.computeDescriptiveStats(data);

        const report = `
Statistical Analysis Report
Dataset: ${selectedDataset}
Generated: ${new Date().toLocaleString()}

DESCRIPTIVE STATISTICS
====================

Measures of Central Tendency:
• Mean: ${stats.mean}
• Median: ${stats.median}
• Mode: ${stats.mode}

Measures of Spread:
• Range: ${stats.range}
• Variance: ${stats.variance}
• Standard Deviation: ${stats.stdDev}
• Interquartile Range: ${stats.iqr}

Quartiles:
• Q1 (25th percentile): ${stats.q1}
• Q2 (50th percentile): ${stats.q2}
• Q3 (75th percentile): ${stats.q3}

Summary:
• Count: ${stats.count}
• Sum: ${stats.sum}
• Minimum: ${stats.min}
• Maximum: ${stats.max}

Raw Data:
${data.join(', ')}
        `;

        this.downloadText(report, `${selectedDataset}_statistics.txt`);
    }

    downloadText(content, filename) {
        const element = document.createElement('a');
        element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(content));
        element.setAttribute('download', filename);
        element.style.display = 'none';
        document.body.appendChild(element);
        element.click();
        document.body.removeChild(element);
    }

    // ==================== DATA VISUALIZATION ====================

    generateChart() {
        const selectedDataset = document.getElementById('viz-dataset-select').value;
        const chartType = document.getElementById('chart-type-select').value;

        if (!selectedDataset) return;

        const data = this.datasets.get(selectedDataset);
        if (!data) return;

        const ctx = document.getElementById('data-chart').getContext('2d');

        if (this.chart) {
            this.chart.destroy();
        }

        switch (chartType) {
            case 'histogram':
                this.createHistogram(ctx, data, selectedDataset);
                break;
            case 'bar':
                this.createBarChart(ctx, data, selectedDataset);
                break;
            case 'pie':
                this.createPieChart(ctx, data, selectedDataset);
                break;
            case 'scatter':
                this.createScatterPlot(ctx, data, selectedDataset);
                break;
            case 'line':
                this.createLineChart(ctx, data, selectedDataset);
                break;
            case 'box':
                this.createBoxPlot(ctx, data, selectedDataset);
                break;
        }
    }

    createHistogram(ctx, data, title) {
        const bins = this.createBins(data, 10);

        this.chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: bins.map(bin => `${bin.min.toFixed(1)}-${bin.max.toFixed(1)}`),
                datasets: [{
                    label: 'Frequency',
                    data: bins.map(bin => bin.count),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: `Histogram - ${title}`
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Frequency'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Value Range'
                        }
                    }
                }
            }
        });
    }

    createBarChart(ctx, data, title) {
        const frequency = {};
        data.forEach(val => frequency[val] = (frequency[val] || 0) + 1);

        const labels = Object.keys(frequency).sort((a, b) => parseFloat(a) - parseFloat(b));
        const values = labels.map(label => frequency[label]);

        this.chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Frequency',
                    data: values,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: `Bar Chart - ${title}`
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Frequency'
                        }
                    }
                }
            }
        });
    }

    createPieChart(ctx, data, title) {
        const frequency = {};
        data.forEach(val => frequency[val] = (frequency[val] || 0) + 1);

        const labels = Object.keys(frequency);
        const values = Object.values(frequency);
        const colors = this.generateColors(labels.length);

        this.chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: colors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: `Pie Chart - ${title}`
                    },
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                }
            }
        });
    }

    createScatterPlot(ctx, data, title) {
        const points = data.map((y, x) => ({ x, y }));

        this.chart = new Chart(ctx, {
            type: 'scatter',
            data: {
                datasets: [{
                    label: 'Data Points',
                    data: points,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: `Scatter Plot - ${title}`
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Index'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Value'
                        }
                    }
                }
            }
        });
    }

    createLineChart(ctx, data, title) {
        const labels = data.map((_, index) => index + 1);

        this.chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Values',
                    data: data,
                    borderColor: 'rgba(153, 102, 255, 1)',
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: `Line Chart - ${title}`
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Index'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Value'
                        }
                    }
                }
            }
        });
    }

    createBoxPlot(ctx, data, title) {
        const sorted = [...data].sort((a, b) => a - b);
        const stats = this.computeDescriptiveStats(data);

        // Create a simplified box plot using bar chart
        const boxData = {
            labels: ['Box Plot'],
            datasets: [{
                label: 'Min',
                data: [parseFloat(stats.min)],
                backgroundColor: 'rgba(255, 206, 86, 0.6)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }, {
                label: 'Q1',
                data: [parseFloat(stats.q1)],
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }, {
                label: 'Median',
                data: [parseFloat(stats.median)],
                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }, {
                label: 'Q3',
                data: [parseFloat(stats.q3)],
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }, {
                label: 'Max',
                data: [parseFloat(stats.max)],
                backgroundColor: 'rgba(153, 102, 255, 0.6)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        };

        this.chart = new Chart(ctx, {
            type: 'bar',
            data: boxData,
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: `Box Plot Statistics - ${title}`
                    }
                },
                scales: {
                    y: {
                        title: {
                            display: true,
                            text: 'Value'
                        }
                    }
                }
            }
        });
    }

    createBins(data, binCount) {
        const min = Math.min(...data);
        const max = Math.max(...data);
        const binWidth = (max - min) / binCount;

        const bins = [];
        for (let i = 0; i < binCount; i++) {
            const binMin = min + i * binWidth;
            const binMax = min + (i + 1) * binWidth;
            bins.push({
                min: binMin,
                max: binMax,
                count: 0
            });
        }

        data.forEach(value => {
            const binIndex = Math.min(Math.floor((value - min) / binWidth), binCount - 1);
            bins[binIndex].count++;
        });

        return bins;
    }

    generateColors(count) {
        const colors = [];
        for (let i = 0; i < count; i++) {
            const hue = (i * 137.508) % 360;
            colors.push(`hsl(${hue}, 70%, 60%)`);
        }
        return colors;
    }

    // ==================== INFERENTIAL STATISTICS ====================

    calculateCorrelation() {
        const dataset1Name = document.getElementById('correlation-dataset1').value;
        const dataset2Name = document.getElementById('correlation-dataset2').value;

        if (!dataset1Name || !dataset2Name) {
            this.showAlert('Please select both datasets for correlation analysis.', 'warning');
            return;
        }

        const data1 = this.datasets.get(dataset1Name);
        const data2 = this.datasets.get(dataset2Name);

        if (!data1 || !data2) {
            this.showAlert('Selected datasets not found.', 'danger');
            return;
        }

        if (data1.length !== data2.length) {
            this.showAlert('Datasets must have the same number of data points for correlation analysis.', 'warning');
            return;
        }

        const pearsonR = this.calculatePearsonCorrelation(data1, data2);
        const spearmanR = this.calculateSpearmanCorrelation(data1, data2);

        const resultsDiv = document.getElementById('correlation-results');
        resultsDiv.innerHTML = `
            <div class="alert alert-info">
                <h6><i class="fas fa-chart-line"></i> Correlation Results</h6>
                <p><strong>Pearson Correlation:</strong> ${pearsonR.toFixed(4)}</p>
                <p><strong>Spearman Correlation:</strong> ${spearmanR.toFixed(4)}</p>
                <p><strong>Interpretation:</strong> ${this.interpretCorrelation(pearsonR)}</p>
            </div>
        `;
    }

    calculatePearsonCorrelation(x, y) {
        const n = x.length;
        const sumX = x.reduce((a, b) => a + b, 0);
        const sumY = y.reduce((a, b) => a + b, 0);
        const sumXY = x.reduce((sum, xi, i) => sum + xi * y[i], 0);
        const sumX2 = x.reduce((sum, xi) => sum + xi * xi, 0);
        const sumY2 = y.reduce((sum, yi) => sum + yi * yi, 0);

        const numerator = n * sumXY - sumX * sumY;
        const denominator = Math.sqrt((n * sumX2 - sumX * sumX) * (n * sumY2 - sumY * sumY));

        return denominator === 0 ? 0 : numerator / denominator;
    }

    calculateSpearmanCorrelation(x, y) {
        const rankX = this.getRanks(x);
        const rankY = this.getRanks(y);
        return this.calculatePearsonCorrelation(rankX, rankY);
    }

    getRanks(data) {
        const sorted = data.map((value, index) => ({ value, index }))
            .sort((a, b) => a.value - b.value);

        const ranks = new Array(data.length);
        sorted.forEach((item, rank) => {
            ranks[item.index] = rank + 1;
        });

        return ranks;
    }

    interpretCorrelation(r) {
        const abs = Math.abs(r);
        if (abs >= 0.9) return 'Very strong correlation';
        if (abs >= 0.7) return 'Strong correlation';
        if (abs >= 0.5) return 'Moderate correlation';
        if (abs >= 0.3) return 'Weak correlation';
        return 'Very weak or no correlation';
    }

    runHypothesisTest() {
        const testType = document.getElementById('hypothesis-test-type').value;
        const resultsDiv = document.getElementById('hypothesis-results');

        // For demonstration, we'll show a simple t-test
        if (testType === 'ttest') {
            const selectedDataset = document.getElementById('dataset-select').value;
            if (!selectedDataset) {
                this.showAlert('Please select a dataset first.', 'warning');
                return;
            }

            const data = this.datasets.get(selectedDataset);
            const tTestResult = this.oneSampleTTest(data, 0); // Test against population mean of 0

            resultsDiv.innerHTML = `
                <div class="alert alert-info">
                    <h6><i class="fas fa-calculator"></i> One-Sample t-Test Results</h6>
                    <p><strong>Test Statistic (t):</strong> ${tTestResult.t.toFixed(4)}</p>
                    <p><strong>Degrees of Freedom:</strong> ${tTestResult.df}</p>
                    <p><strong>P-value (approximate):</strong> ${tTestResult.p.toFixed(4)}</p>
                    <p><strong>Interpretation:</strong> ${tTestResult.p < 0.05 ? 'Statistically significant' : 'Not statistically significant'}</p>
                </div>
            `;
        } else {
            resultsDiv.innerHTML = `
                <div class="alert alert-warning">
                    <p><i class="fas fa-info-circle"></i> This test type is not yet implemented. Please select t-Test.</p>
                </div>
            `;
        }
    }

    oneSampleTTest(data, populationMean) {
        const n = data.length;
        const mean = data.reduce((a, b) => a + b, 0) / n;
        const variance = data.reduce((sum, val) => sum + Math.pow(val - mean, 2), 0) / (n - 1);
        const stdDev = Math.sqrt(variance);
        const tStatistic = (mean - populationMean) / (stdDev / Math.sqrt(n));
        const df = n - 1;

        // Approximate p-value for two-tailed test
        const pValue = this.approximatePValue(Math.abs(tStatistic), df);

        return { t: tStatistic, df: df, p: pValue };
    }

    approximatePValue(t, df) {
        // Simple approximation for p-value
        // In a real implementation, you'd use a proper statistical library
        if (t > 3) return 0.001;
        if (t > 2.5) return 0.01;
        if (t > 2) return 0.05;
        if (t > 1.5) return 0.1;
        return 0.2;
    }

    runRegression() {
        const xDatasetName = document.getElementById('regression-x').value;
        const yDatasetName = document.getElementById('regression-y').value;

        if (!xDatasetName || !yDatasetName) {
            this.showAlert('Please select both X and Y datasets for regression analysis.', 'warning');
            return;
        }

        const xData = this.datasets.get(xDatasetName);
        const yData = this.datasets.get(yDatasetName);

        if (!xData || !yData) {
            this.showAlert('Selected datasets not found.', 'danger');
            return;
        }

        if (xData.length !== yData.length) {
            this.showAlert('Datasets must have the same number of data points for regression analysis.', 'warning');
            return;
        }

        const regression = this.calculateLinearRegression(xData, yData);
        const resultsDiv = document.getElementById('regression-results');

        resultsDiv.innerHTML = `
            <div class="alert alert-info">
                <h6><i class="fas fa-chart-line"></i> Linear Regression Results</h6>
                <p><strong>Equation:</strong> y = ${regression.slope.toFixed(4)}x + ${regression.intercept.toFixed(4)}</p>
                <p><strong>R-squared:</strong> ${regression.rSquared.toFixed(4)}</p>
                <p><strong>Correlation:</strong> ${regression.correlation.toFixed(4)}</p>
                <p><strong>Standard Error:</strong> ${regression.standardError.toFixed(4)}</p>
            </div>
        `;
    }

    calculateLinearRegression(x, y) {
        const n = x.length;
        const sumX = x.reduce((a, b) => a + b, 0);
        const sumY = y.reduce((a, b) => a + b, 0);
        const sumXY = x.reduce((sum, xi, i) => sum + xi * y[i], 0);
        const sumX2 = x.reduce((sum, xi) => sum + xi * xi, 0);
        const sumY2 = y.reduce((sum, yi) => sum + yi * yi, 0);

        const slope = (n * sumXY - sumX * sumY) / (n * sumX2 - sumX * sumX);
        const intercept = (sumY - slope * sumX) / n;

        // Calculate R-squared
        const meanY = sumY / n;
        const totalSumSquares = y.reduce((sum, yi) => sum + Math.pow(yi - meanY, 2), 0);
        const residualSumSquares = y.reduce((sum, yi, i) => {
            const predicted = slope * x[i] + intercept;
            return sum + Math.pow(yi - predicted, 2);
        }, 0);
        const rSquared = 1 - (residualSumSquares / totalSumSquares);

        // Calculate correlation
        const correlation = this.calculatePearsonCorrelation(x, y);

        // Calculate standard error
        const standardError = Math.sqrt(residualSumSquares / (n - 2));

        return {
            slope,
            intercept,
            rSquared,
            correlation,
            standardError
        };
    }

    // ==================== UTILITY FUNCTIONS ====================

    showAlert(message, type = 'info') {
        // Create alert element
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        // Insert at the top of the container
        const container = document.querySelector('.demo-section .container');
        container.insertBefore(alertDiv, container.firstChild);

        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.parentNode.removeChild(alertDiv);
            }
        }, 5000);
    }
}

// Initialize the statistics calculator when the page loads
let statsCalc;
document.addEventListener('DOMContentLoaded', function() {
    statsCalc = new StatisticsCalculator();
});