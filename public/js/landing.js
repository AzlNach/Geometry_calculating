document.addEventListener('DOMContentLoaded', function() {
    // --- START: IMPROVED THREE.JS ANIMATION ---
    const heroCanvas = document.getElementById('hero-canvas');
    if (heroCanvas) {
        // 1. Scene, Camera, and Renderer Setup
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, heroCanvas.clientWidth / heroCanvas.clientHeight, 0.1, 1000);
        camera.position.z = 25; // Pindahkan kamera sedikit ke belakang untuk melihat lebih banyak

        const renderer = new THREE.WebGLRenderer({
            antialias: true,
            alpha: true // Aktifkan latar belakang transparan
        });
        renderer.setSize(heroCanvas.clientWidth, heroCanvas.clientHeight);
        renderer.setPixelRatio(window.devicePixelRatio); // Render tajam di layar HiDPI
        heroCanvas.innerHTML = ''; // Hapus konten lama jika ada
        heroCanvas.appendChild(renderer.domElement);

        // 2. Enhanced Lighting
        // Cahaya Hemisphere memberikan warna gradien pada scene (biru langit ke biru tua)
        const hemisphereLight = new THREE.HemisphereLight(0x00A8E8, 0x213448, 1);
        scene.add(hemisphereLight);

        // Cahaya Directional meniru matahari, memberikan bayangan dan highlight yang jelas
        const directionalLight = new THREE.DirectionalLight(0xffffff, 1.2);
        directionalLight.position.set(10, 10, 10);
        scene.add(directionalLight);

        // 3. Create a Group of Complex Shapes
        const shapesGroup = new THREE.Group();
        const shapeGeometries = [
            new THREE.IcosahedronGeometry(1.2, 0), // Polihedron
            new THREE.DodecahedronGeometry(1.2, 0), // Polihedron lain
            new THREE.TorusKnotGeometry(1, 0.3, 100, 16), // Simpul
            new THREE.TorusGeometry(1.2, 0.25, 16, 100), // Donat
        ];

        // Material yang lebih modern dengan efek metalik dan reflektif
        const solidMaterial = new THREE.MeshStandardMaterial({
            color: 0xffffff,
            metalness: 0.2,
            roughness: 0.3,
            transparent: true,
            opacity: 0.9
        });

        // Material wireframe untuk memberikan detail teknis
        const wireframeMaterial = new THREE.MeshBasicMaterial({
            color: 0x00A8E8, // Warna aksen untuk wireframe
            wireframe: true,
            transparent: true,
            opacity: 0.25
        });

        // Buat 50 bentuk acak
        for (let i = 0; i < 50; i++) {
            const geometry = shapeGeometries[Math.floor(Math.random() * shapeGeometries.length)];
            const shapeObject = new THREE.Group();

            const solidMesh = new THREE.Mesh(geometry, solidMaterial);
            const wireframeMesh = new THREE.Mesh(geometry, wireframeMaterial);
            // Buat wireframe sedikit lebih besar untuk menghindari tumpang tindih visual (z-fighting)
            wireframeMesh.scale.set(1.001, 1.001, 1.001);

            shapeObject.add(solidMesh);
            shapeObject.add(wireframeMesh);

            // Posisi acak dalam area seperti bola
            const [x, y, z] = [
                (Math.random() - 0.5) * 40,
                (Math.random() - 0.5) * 40,
                (Math.random() - 0.5) * 40
            ];
            shapeObject.position.set(x, y, z);

            // Rotasi awal acak
            shapeObject.rotation.set(Math.random() * Math.PI, Math.random() * Math.PI, Math.random() * Math.PI);

            // Skala acak
            const scale = Math.random() * 0.4 + 0.5;
            shapeObject.scale.set(scale, scale, scale);

            // Simpan kecepatan rotasi acak untuk loop animasi
            shapeObject.userData.rotationSpeed = {
                x: (Math.random() - 0.5) * 0.005,
                y: (Math.random() - 0.5) * 0.005
            };
            shapesGroup.add(shapeObject);
        }
        scene.add(shapesGroup);

        // 4. Mouse Interaction
        let mouse = new THREE.Vector2();
        const onMouseMove = (event) => {
            // Normalisasi posisi mouse dari -1 hingga 1
            mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
            mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
        };
        window.addEventListener('mousemove', onMouseMove, false);

        // 5. Animation Loop
        const clock = new THREE.Clock();
        const animate = () => {
            requestAnimationFrame(animate);

            // Animasikan setiap bentuk secara individual
            shapesGroup.children.forEach(shape => {
                shape.rotation.x += shape.userData.rotationSpeed.x;
                shape.rotation.y += shape.userData.rotationSpeed.y;
            });

            // Animasikan seluruh grup berdasarkan posisi mouse untuk efek paralaks
            // Menggunakan 'lerp' untuk transisi yang mulus
            const targetRotationX = (mouse.y * Math.PI) / 12;
            const targetRotationY = (mouse.x * Math.PI) / 12;
            shapesGroup.rotation.x = THREE.MathUtils.lerp(shapesGroup.rotation.x, targetRotationX, 0.05);
            shapesGroup.rotation.y = THREE.MathUtils.lerp(shapesGroup.rotation.y, targetRotationY, 0.05);

            renderer.render(scene, camera);
        };
        animate();

        // 6. Handle Window Resize
        const onWindowResize = () => {
            const width = heroCanvas.clientWidth;
            const height = heroCanvas.clientHeight;
            camera.aspect = width / height;
            camera.updateProjectionMatrix();
            renderer.setSize(width, height);
        };
        window.addEventListener('resize', onWindowResize, false);
    }
    // --- END: IMPROVED THREE.JS ANIMATION ---


    // Handle feature carousel resizing
    const carousel = document.querySelector('.carousel');
    const group = document.querySelector('.group');

    function adjustCarousel() {
        if (!carousel || !group) return;
        const uniqueCardCount = Math.floor(group.children.length / 2);
        if (uniqueCardCount === 0) return;

        document.documentElement.style.setProperty('--card-count', uniqueCardCount);
        const cardWidth = document.querySelector('.card-container').offsetWidth;
        document.documentElement.style.setProperty('--card-width', cardWidth + 'px');
        const totalWidth = cardWidth * uniqueCardCount;
        document.documentElement.style.setProperty('--total-width', totalWidth + 'px');
        const duration = Math.max(15, totalWidth / 60);
        group.style.animationDuration = `${duration}s`;
    }

    window.addEventListener('load', adjustCarousel);
    window.addEventListener('resize', adjustCarousel);
});