/**
 * Hero Section Background Animation
 *
 * This script uses anime.js to create a subtle, elegant animation of geometric
 * shapes (squares and circles) in the background of the hero section.
 * The shapes are generated dynamically and animated in a continuous loop.
 */
document.addEventListener('DOMContentLoaded', () => {

    const animationContainer = document.querySelector('.hero-section');

    if (animationContainer) {

        const shapesContainer = document.createElement('div');
        shapesContainer.className = 'shapes-container';

        animationContainer.prepend(shapesContainer);

        const numShapes = 30;


        for (let i = 0; i < numShapes; i++) {
            const shape = document.createElement('div');
            shape.classList.add('shape');


            if (Math.random() > 0.5) {
                shape.classList.add('circle');
            }


            const size = anime.random(20, 80) + 'px';
            shape.style.width = size;
            shape.style.height = size;


            shape.style.top = anime.random(0, 100) + '%';
            shape.style.left = anime.random(0, 100) + '%';


            shape.style.opacity = anime.random(10, 40) / 100;

            shapesContainer.appendChild(shape);
        }


        const animateShapes = () => {
            anime({
                targets: '.shape',

                translateX: () => anime.random(-150, 150),
                translateY: () => anime.random(-150, 150),

                scale: () => anime.random(0.7, 1.8),
                rotate: () => anime.random(-360, 360),

                duration: () => anime.random(4000, 8000),
                easing: 'easeInOutQuad',

                delay: anime.stagger(100),

                complete: animateShapes,
            });
        };


        animateShapes();
    }
});