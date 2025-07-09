document.addEventListener('DOMContentLoaded', function() {

    const demoBase = document.getElementById('demo-base');
    const demoHeight = document.getElementById('demo-height');
    const demoBaseValue = document.getElementById('demo-base-value');
    const demoHeightValue = document.getElementById('demo-height-value');
    const demoResult = document.getElementById('demo-result');
    const demoTriangle = document.getElementById('demo-triangle');
    const demoBaseText = document.getElementById('demo-base-text');
    const demoHeightText = document.getElementById('demo-height-text');
    const demoHeightLine = document.getElementById('demo-height-line');
    const demoBaseLine = document.getElementById('demo-base-line');

    function updateTriangleDemo() {
        const base = parseInt(demoBase.value);
        const height = parseInt(demoHeight.value);
        const area = 0.5 * base * height;


        demoBaseValue.textContent = base;
        demoHeightValue.textContent = height;
        demoResult.textContent = `Area: ${area}`;


        const svgWidth = 300;
        const svgHeight = 225;
        const padding = 25;
        const maxBase = 150;
        const maxHeight = 150;


        const baseScale = Math.min(1, (svgWidth - 2 * padding) / base);
        const heightScale = Math.min(1, (svgHeight - 2 * padding) / height);
        const scale = Math.min(baseScale, heightScale) * 0.8;


        const scaledBase = base * scale;
        const scaledHeight = height * scale;


        const centerX = svgWidth / 2;
        const centerY = svgHeight - padding - 20;


        const x1 = centerX;
        const y1 = centerY - scaledHeight;
        const x2 = centerX - (scaledBase / 2);
        const y2 = centerY;
        const x3 = centerX + (scaledBase / 2);
        const y3 = centerY;


        demoTriangle.setAttribute('points', `${x1},${y1} ${x2},${y2} ${x3},${y3}`);


        demoHeightLine.setAttribute('x1', x1);
        demoHeightLine.setAttribute('y1', y1);
        demoHeightLine.setAttribute('x2', x1);
        demoHeightLine.setAttribute('y2', y2);


        demoBaseLine.setAttribute('x1', x2);
        demoBaseLine.setAttribute('y1', y2);
        demoBaseLine.setAttribute('x2', x3);
        demoBaseLine.setAttribute('y2', y3);



        const baseLabel = document.getElementById('base-label');
        baseLabel.setAttribute('transform', `translate(${centerX - 74}, ${y2 + 20})`);
        demoBaseText.textContent = `Base: ${base}`;


        const heightLabel = document.getElementById('height-label');
        const midHeight = y1 + (scaledHeight / 2);
        heightLabel.setAttribute('transform', `translate(${x1 + 10}, ${midHeight + 20})`);
        demoHeightText.textContent = `Height: ${height}`;


        const areaLabel = document.getElementById('area-label');
        areaLabel.setAttribute('transform', `translate(${centerX - 44}, ${y1+ 20})`);
        document.getElementById('demo-area-text').textContent = `Area: ${area}`;


        demoResult.textContent = `Area: ${area}`;
    }

    demoBase.addEventListener('input', updateTriangleDemo);
    demoHeight.addEventListener('input', updateTriangleDemo);


    updateTriangleDemo();
});