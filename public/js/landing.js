document.addEventListener('DOMContentLoaded', function() {
    const heroCanvas = document.getElementById('hero-canvas');
    if (!heroCanvas) return;

    // 1. Inisialisasi scene, camera, dan renderer
    const scene = new THREE.Scene();
    scene.background = null; // Background transparan

    const camera = new THREE.PerspectiveCamera(
        75,
        heroCanvas.clientWidth / heroCanvas.clientHeight,
        0.1,
        1000
    );
    camera.position.z = 30;

    const renderer = new THREE.WebGLRenderer({
        antialias: true,
        alpha: true
    });
    renderer.setSize(heroCanvas.clientWidth, heroCanvas.clientHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    heroCanvas.innerHTML = '';
    heroCanvas.appendChild(renderer.domElement);

    // 2. Enhanced Lighting dengan efek dinamis
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
    scene.add(ambientLight);

    const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
    directionalLight.position.set(5, 5, 5);
    scene.add(directionalLight);

    const pointLight = new THREE.PointLight(0x00a8e8, 1, 100);
    pointLight.position.set(0, 0, 20);
    scene.add(pointLight);

    // 3. Create a Group of Complex Shapes with physics
    const shapesGroup = new THREE.Group();
    const geometries = [
        new THREE.IcosahedronGeometry(1.5, 0),
        new THREE.DodecahedronGeometry(1.5, 0),
        new THREE.TorusKnotGeometry(1.2, 0.4, 128, 32),
        new THREE.TorusGeometry(1.5, 0.4, 32, 100),
        new THREE.OctahedronGeometry(1.5, 0),
        new THREE.ConeGeometry(1.2, 2, 8)
    ];

    const materials = [
        new THREE.MeshPhysicalMaterial({
            color: 0xffffff,
            metalness: 0.6,
            roughness: 0.2,
            clearcoat: 0.8,
            transparent: true,
            opacity: 0.9,
            side: THREE.DoubleSide
        }),
        new THREE.MeshPhysicalMaterial({
            color: 0x00a8e8,
            metalness: 0.4,
            roughness: 0.3,
            transparent: true,
            opacity: 0.85,
            side: THREE.DoubleSide
        }),
        new THREE.MeshPhysicalMaterial({
            color: 0x213448,
            metalness: 0.7,
            roughness: 0.1,
            transparent: true,
            opacity: 0.9,
            side: THREE.DoubleSide
        })
    ];

    // Particle system untuk efek latar belakang
    const particleCount = 500;
    const particles = new THREE.BufferGeometry();
    const posArray = new Float32Array(particleCount * 3);

    for (let i = 0; i < particleCount * 3; i++) {
        posArray[i] = (Math.random() - 0.5) * 100;
    }

    particles.setAttribute('position', new THREE.BufferAttribute(posArray, 3));
    const particleMaterial = new THREE.PointsMaterial({
        size: 0.1,
        color: 0xffffff,
        transparent: true,
        opacity: 0.5
    });

    const particleMesh = new THREE.Points(particles, particleMaterial);
    scene.add(particleMesh);

    // Animasi partikel dengan anime.js
    anime({
        targets: particleMesh.geometry.attributes.position.array,
        update: function(anim) {
            const positions = particleMesh.geometry.attributes.position.array;
            for (let i = 0; i < positions.length; i += 3) {
                positions[i] += (Math.random() - 0.5) * 0.1;
                positions[i + 1] += (Math.random() - 0.5) * 0.1;
                positions[i + 2] += (Math.random() - 0.5) * 0.1;
            }
            particleMesh.geometry.attributes.position.needsUpdate = true;
        },
        duration: Infinity
    });

    // 4. Shape creation with physics simulation
    const shapes = [];
    const shapeCount = 20;

    for (let i = 0; i < shapeCount; i++) {
        const geometry = geometries[Math.floor(Math.random() * geometries.length)];
        const material = materials[Math.floor(Math.random() * materials.length)];

        const shape = new THREE.Mesh(geometry, material);

        // Position with spherical distribution
        const radius = 15 + Math.random() * 10;
        const theta = Math.random() * Math.PI * 2;
        const phi = Math.acos(2 * Math.random() - 1);

        shape.position.set(
            radius * Math.sin(phi) * Math.cos(theta),
            radius * Math.sin(phi) * Math.sin(theta),
            radius * Math.cos(phi)
        );

        // Random scale
        const scale = 0.8 + Math.random() * 0.8;
        shape.scale.set(scale, scale, scale);

        // Random rotation
        shape.rotation.set(
            Math.random() * Math.PI * 2,
            Math.random() * Math.PI * 2,
            Math.random() * Math.PI * 2
        );

        // Physics properties
        shape.userData = {
            velocity: new THREE.Vector3(
                (Math.random() - 0.5) * 0.1,
                (Math.random() - 0.5) * 0.1,
                (Math.random() - 0.5) * 0.1
            ),
            rotationSpeed: new THREE.Vector3(
                (Math.random() - 0.5) * 0.01,
                (Math.random() - 0.5) * 0.01,
                (Math.random() - 0.5) * 0.01
            ),
            hovered: false,
            originalColor: material.color.clone(),
            originalScale: scale
        };

        shapes.push(shape);
        shapesGroup.add(shape);
    }

    scene.add(shapesGroup);

    // 5. Mouse Interaction
    const mouse = new THREE.Vector2();
    const raycaster = new THREE.Raycaster();

    window.addEventListener('mousemove', (event) => {
        mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
        mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
    });

    // Interaksi klik untuk efek ledakan
    window.addEventListener('click', () => {
        raycaster.setFromCamera(mouse, camera);
        const intersects = raycaster.intersectObjects(shapes);

        if (intersects.length > 0) {
            const clickedShape = intersects[0].object;

            // Anime.js untuk efek ledakan
            anime({
                targets: clickedShape.position,
                x: clickedShape.position.x * 2,
                y: clickedShape.position.y * 2,
                z: clickedShape.position.z * 2,
                duration: 1000,
                easing: 'easeOutExpo',
                complete: () => {
                    anime({
                        targets: clickedShape.position,
                        x: clickedShape.position.x / 2,
                        y: clickedShape.position.y / 2,
                        z: clickedShape.position.z / 2,
                        duration: 2000,
                        easing: 'easeOutElastic'
                    });
                }
            });

            // Animasi material dengan anime.js
            anime({
                targets: clickedShape.material,
                color: new THREE.Color(Math.random() * 0xffffff),
                duration: 500,
                easing: 'easeOutQuad'
            });
        }
    });

    // 6. Animation Loop dengan physics
    const clock = new THREE.Clock();

    const animate = () => {
        requestAnimationFrame(animate);

        const delta = clock.getDelta();
        const time = clock.getElapsedTime();

        // Animate particles
        particleMesh.rotation.y = time * 0.1;

        // Animate point light
        pointLight.position.x = Math.sin(time) * 15;
        pointLight.position.y = Math.cos(time * 0.7) * 10;

        // Physics simulation
        shapes.forEach(shape => {
            // Update position with velocity
            shape.position.add(shape.userData.velocity);

            // Update rotation
            shape.rotation.x += shape.userData.rotationSpeed.x;
            shape.rotation.y += shape.userData.rotationSpeed.y;
            shape.rotation.z += shape.userData.rotationSpeed.z;

            // Boundary collision
            const distance = shape.position.length();
            if (distance > 25) {
                shape.userData.velocity.multiplyScalar(-0.8);
            }

            // Raycasting for hover effect
            raycaster.setFromCamera(mouse, camera);
            const intersects = raycaster.intersectObject(shape);

            if (intersects.length > 0 && !shape.userData.hovered) {
                shape.userData.hovered = true;

                // Anime.js hover effect
                anime({
                    targets: shape.scale,
                    x: shape.userData.originalScale * 1.5,
                    y: shape.userData.originalScale * 1.5,
                    z: shape.userData.originalScale * 1.5,
                    duration: 300,
                    easing: 'easeOutQuad'
                });

                anime({
                    targets: shape.material,
                    color: new THREE.Color(0xffcc00),
                    duration: 300,
                    easing: 'easeOutQuad'
                });
            } else if (intersects.length === 0 && shape.userData.hovered) {
                shape.userData.hovered = false;

                anime({
                    targets: shape.scale,
                    x: shape.userData.originalScale,
                    y: shape.userData.originalScale,
                    z: shape.userData.originalScale,
                    duration: 500,
                    easing: 'easeOutElastic'
                });

                anime({
                    targets: shape.material,
                    color: shape.userData.originalColor,
                    duration: 800,
                    easing: 'easeOutQuad'
                });
            }
        });

        // Group rotation based on mouse
        shapesGroup.rotation.x = THREE.MathUtils.lerp(
            shapesGroup.rotation.x,
            mouse.y * 0.2,
            0.05
        );

        shapesGroup.rotation.y = THREE.MathUtils.lerp(
            shapesGroup.rotation.y,
            mouse.x * 0.2,
            0.05
        );

        renderer.render(scene, camera);
    };

    animate();

    // 7. Handle Window Resize
    window.addEventListener('resize', () => {
        camera.aspect = heroCanvas.clientWidth / heroCanvas.clientHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(heroCanvas.clientWidth, heroCanvas.clientHeight);
    });

    // 8. Tambahkan efek hover pada canvas
    const overlay = heroCanvas.querySelector('.hero-overlay');
    if (overlay) {
        heroCanvas.addEventListener('mouseenter', () => {
            overlay.style.opacity = '1';
        });

        heroCanvas.addEventListener('mouseleave', () => {
            overlay.style.opacity = '0';
        });
    } else {
        // Jika overlay tidak ditemukan, buat secara dinamis
        const newOverlay = document.createElement('div');
        newOverlay.className = 'hero-overlay';
        newOverlay.innerHTML = `
        <div class="interaction-hint">
            <span class="material-symbols-rounded">touch_app</span>
            <span>Interact with the shapes!</span>
        </div>
    `;
        heroCanvas.appendChild(newOverlay);

        heroCanvas.addEventListener('mouseenter', () => {
            newOverlay.style.opacity = '1';
        });

        heroCanvas.addEventListener('mouseleave', () => {
            newOverlay.style.opacity = '0';
        });
    }

    // 9. Animasi masuk awal dengan anime.js
    anime({
        targets: shapesGroup.rotation,
        y: [Math.PI * 2, 0],
        duration: 2000,
        easing: 'easeOutElastic',
        delay: 500
    });

    shapes.forEach((shape, i) => {
        const targetPosition = { // Temporary object for anime.js to tween
            x: shape.position.x,
            y: shape.position.y,
            z: shape.position.z
        };

        const newPosArr = (() => { // IIFE to calculate new position
            const radius = 10 + Math.random() * 5;
            const theta = Math.random() * Math.PI * 2;
            const phi = Math.acos(2 * Math.random() - 1);
            return [
                radius * Math.sin(phi) * Math.cos(theta),
                radius * Math.sin(phi) * Math.sin(theta),
                radius * Math.cos(phi)
            ];
        })();

        anime({
            targets: targetPosition, // Animate the temporary object
            x: newPosArr[0],
            y: newPosArr[1],
            z: newPosArr[2],
            duration: 1500,
            // Use anime.stagger with a function to apply delay correctly in a loop
            delay: anime.stagger(100, { start: 500 })(i, shapes.length),
            easing: 'easeOutElastic',
            update: function() {
                // Apply the animated values to the actual shape's position
                shape.position.set(targetPosition.x, targetPosition.y, targetPosition.z);
            }
        });
    });
});