document.addEventListener('DOMContentLoaded', function() {
    // Get DOM elements for square calculator
    const demoSide = document.getElementById('demo-side');
    const demoSideValue = document.getElementById('demo-side-value');
    const demoSquareArea = document.getElementById('demo-square-area');
    const demoSquarePerimeter = document.getElementById('demo-square-perimeter');
    const demoSquare = document.getElementById('demo-square');
    const demoSideText = document.getElementById('demo-side-text');
    const demoAreaSquareText = document.getElementById('demo-area-square-text');
    const demoPerimeterText = document.getElementById('demo-perimeter-text');

    // Update square visualization when side length changes
    function updateSquareDemo() {
        const side = parseInt(demoSide.value);
        const area = side * side;
        const perimeter = 4 * side;

        // Update display values
        demoSideValue.textContent = side;
        demoSquareArea.textContent = `Area: ${area}`;
        demoSquarePerimeter.textContent = `Perimeter: ${perimeter}`;

        // SVG visualization constants
        const svgWidth = 300;
        const svgHeight = 225;
        const padding = 25;
        const maxSide = 150;

        // Scale factor to ensure square stays in viewbox
        const scale = Math.min(1, (Math.min(svgWidth, svgHeight) - 2 * padding) / side) * 0.8;

        // Calculate scaled dimensions
        const scaledSide = side * scale;

        // Center position
        const centerX = svgWidth / 2;
        const centerY = svgHeight / 2;

        // Square position (centered)
        const x = centerX - (scaledSide / 2);
        const y = centerY - (scaledSide / 2);

        const y_area = centerY + (scaledSide / 2);

        // Update square
        demoSquare.setAttribute('x', x);
        demoSquare.setAttribute('y', y);
        demoSquare.setAttribute('width', scaledSide);
        demoSquare.setAttribute('height', scaledSide);

        // Update side label position and text
        const sideLabel = document.getElementById('side-label');

        demoSideText.textContent = `Side: ${side}`;

        // Update area label
        const areaLabelSquare = document.getElementById('area-label-square');

        demoAreaSquareText.textContent = `Area: ${area}`;

        // Update perimeter label
        const perimeterLabel = document.getElementById('perimeter-label');

        demoPerimeterText.textContent = `Perimeter: ${perimeter}`;
    }

    // Add event listener to the side slider
    if (demoSide) {
        demoSide.addEventListener('input', updateSquareDemo);
        // Initialize with default values
        updateSquareDemo();
    }
});