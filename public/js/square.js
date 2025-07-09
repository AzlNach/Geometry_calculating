document.addEventListener('DOMContentLoaded', function() {

    const demoSide = document.getElementById('demo-side');
    const demoSideValue = document.getElementById('demo-side-value');
    const demoSquareArea = document.getElementById('demo-square-area');
    const demoSquarePerimeter = document.getElementById('demo-square-perimeter');
    const demoSquare = document.getElementById('demo-square');
    const demoSideText = document.getElementById('demo-side-text');
    const demoAreaSquareText = document.getElementById('demo-area-square-text');
    const demoPerimeterText = document.getElementById('demo-perimeter-text');


    function updateSquareDemo() {
        const side = parseInt(demoSide.value);
        const area = side * side;
        const perimeter = 4 * side;


        demoSideValue.textContent = side;
        demoSquareArea.textContent = `Area: ${area}`;
        demoSquarePerimeter.textContent = `Perimeter: ${perimeter}`;


        const svgWidth = 300;
        const svgHeight = 225;
        const padding = 25;
        const maxSide = 150;


        const scale = Math.min(1, (Math.min(svgWidth, svgHeight) - 2 * padding) / side) * 0.8;


        const scaledSide = side * scale;


        const centerX = svgWidth / 2;
        const centerY = svgHeight / 2;


        const x = centerX - (scaledSide / 2);
        const y = centerY - (scaledSide / 2);

        const y_area = centerY + (scaledSide / 2);


        demoSquare.setAttribute('x', x);
        demoSquare.setAttribute('y', y);
        demoSquare.setAttribute('width', scaledSide);
        demoSquare.setAttribute('height', scaledSide);


        const sideLabel = document.getElementById('side-label');

        demoSideText.textContent = `Side: ${side}`;


        const areaLabelSquare = document.getElementById('area-label-square');

        demoAreaSquareText.textContent = `Area: ${area}`;


        const perimeterLabel = document.getElementById('perimeter-label');

        demoPerimeterText.textContent = `Perimeter: ${perimeter}`;
    }


    if (demoSide) {
        demoSide.addEventListener('input', updateSquareDemo);

        updateSquareDemo();
    }
});