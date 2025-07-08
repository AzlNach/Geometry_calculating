document.addEventListener('DOMContentLoaded', function() {

    const heroCanvas = document.getElementById('hero-canvas');
    const width = heroCanvas.clientWidth;
    const height = heroCanvas.clientHeight;


    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0xf8f9fa);

    const camera = new THREE.PerspectiveCamera(75, width / height, 0.1, 1000);
    camera.position.z = 5;

    const renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(width, height);
    heroCanvas.appendChild(renderer.domElement);


    const controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.dampingFactor = 0.05;


    const triangleGeometry = new THREE.ConeGeometry(1.5, 2, 3);
    const triangleMaterial = new THREE.MeshPhongMaterial({
        color: 0x3b5998,
        shininess: 100,
        specular: 0x111111
    });
    const triangleMesh = new THREE.Mesh(triangleGeometry, triangleMaterial);
    triangleMesh.position.x = -2;
    scene.add(triangleMesh);

    const sphereGeometry = new THREE.SphereGeometry(1, 32, 32);
    const sphereMaterial = new THREE.MeshPhongMaterial({
        color: 0x007bff,
        shininess: 100,
        specular: 0x111111
    });
    const sphereMesh = new THREE.Mesh(sphereGeometry, sphereMaterial);
    sphereMesh.position.x = 2;
    scene.add(sphereMesh);

    const cubeGeometry = new THREE.BoxGeometry(1.5, 1.5, 1.5);
    const cubeMaterial = new THREE.MeshPhongMaterial({
        color: 0xfd8700,
        shininess: 100,
        specular: 0x111111
    });
    const cubeMesh = new THREE.Mesh(cubeGeometry, cubeMaterial);
    scene.add(cubeMesh);


    const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
    scene.add(ambientLight);

    const pointLight = new THREE.PointLight(0xffffff, 1);
    pointLight.position.set(5, 5, 5);
    scene.add(pointLight);


    function animate() {
        requestAnimationFrame(animate);


        triangleMesh.rotation.y += 0.01;
        sphereMesh.rotation.y += 0.01;
        cubeMesh.rotation.y += 0.01;
        cubeMesh.rotation.x += 0.01;

        controls.update();
        renderer.render(scene, camera);
    }


    animate();


    window.addEventListener('resize', function() {
        const width = heroCanvas.clientWidth;
        const height = heroCanvas.clientHeight;

        camera.aspect = width / height;
        camera.updateProjectionMatrix();
        renderer.setSize(width, height);
    });


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


    const carousel = document.querySelector('.carousel');
    const group = document.querySelector('.group');

    function adjustCarousel() {

        if (!carousel || !group) return;


        const uniqueCardCount = Math.floor(group.children.length / 2);
        document.documentElement.style.setProperty('--card-count', uniqueCardCount);


        const cardWidth = document.querySelector('.card-container').offsetWidth;
        document.documentElement.style.setProperty('--card-width', cardWidth + 'px');


        const totalWidth = cardWidth * uniqueCardCount;
        document.documentElement.style.setProperty('--total-width', totalWidth + 'px');



        const duration = Math.max(15, cardWidth * uniqueCardCount / 60);
        group.style.animationDuration = `${duration}s`;

    }


    window.addEventListener('load', adjustCarousel);
    window.addEventListener('resize', adjustCarousel);
});