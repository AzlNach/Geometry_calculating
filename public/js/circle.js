document.addEventListener('DOMContentLoaded', function() {
    // Get DOM elements for circle calculator
    const demoRadius = document.getElementById('demo-radius');
    const demoRadiusValue = document.getElementById('demo-radius-value');
    const demoCircleArea = document.getElementById('demo-circle-area');
    const demoCircleCircumference = document.getElementById('demo-circle-circumference');
    const demoCircle = document.getElementById('demo-circle');
    const demoRadiusText = document.getElementById('demo-radius-text');
    const demoAreaCircleText = document.getElementById('demo-area-circle-text');
    const demoCircumferenceText = document.getElementById('demo-circumference-text');
    const demoRadiusLine = document.getElementById('demo-radius-line');

    // Update circle visualization when radius changes
    function updateCircleDemo() {
        const radius = parseInt(demoRadius.value);
        const area = Math.round(Math.PI * radius * radius);
        const circumference = Math.round(2 * Math.PI * radius);

        // Update display values
        demoRadiusValue.textContent = radius;
        demoCircleArea.textContent = `Area: ${area}`;
        demoCircleCircumference.textContent = `Circumference: ${circumference}`;

        // SVG visualization constants
        const svgWidth = 300;
        const svgHeight = 225;
        const padding = 25;
        const maxRadius = 100;

        // Scale factor to ensure circle stays in viewbox
        const scale = Math.min(1, (Math.min(svgWidth, svgHeight) / 2 - padding) / radius) * 0.8;

        // Calculate scaled dimensions
        const scaledRadius = radius * scale;

        // Center position
        const centerX = svgWidth / 2;
        const centerY = svgHeight / 2;

        // Update circle
        demoCircle.setAttribute('cx', centerX);
        demoCircle.setAttribute('cy', centerY);
        demoCircle.setAttribute('r', scaledRadius);

        // Update radius line
        demoRadiusLine.setAttribute('x1', centerX);
        demoRadiusLine.setAttribute('y1', centerY);
        demoRadiusLine.setAttribute('x2', centerX + scaledRadius);
        demoRadiusLine.setAttribute('y2', centerY);

        // Update label text only, keeping fixed positions
        demoRadiusText.textContent = `Radius: ${radius}`;
        demoAreaCircleText.textContent = `Area: ${area}`;
        demoCircumferenceText.textContent = `Circum: ${circumference}`;
    }

    // Add event listener to the radius slider
    if (demoRadius) {
        demoRadius.addEventListener('input', updateCircleDemo);
        // Initialize with default values
        updateCircleDemo();
    }
});