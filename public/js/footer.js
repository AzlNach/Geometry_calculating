document.addEventListener('DOMContentLoaded', function() {

    const socialLinks = document.querySelectorAll('.social-links a');

    socialLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) rotate(10deg)';
        });

        link.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) rotate(0)';
        });
    });


    const currentYear = new Date().getFullYear();
    const copyrightElement = document.querySelector('.copyright');
    if (copyrightElement) {
        copyrightElement.innerHTML = copyrightElement.innerHTML.replace(/\d{4}/, currentYear);
    }


    const footerSection = document.querySelector('.footer');

    if (footerSection) {
        const scrollToTopBtn = document.createElement('div');
        scrollToTopBtn.innerHTML = '<span class="material-symbols-rounded">arrow_upward</span>';
        scrollToTopBtn.style.position = 'fixed';
        scrollToTopBtn.style.bottom = '20px';
        scrollToTopBtn.style.right = '20px';
        scrollToTopBtn.style.width = '50px';
        scrollToTopBtn.style.height = '50px';
        scrollToTopBtn.style.backgroundColor = '#fd8700';
        scrollToTopBtn.style.color = 'white';
        scrollToTopBtn.style.borderRadius = '50%';
        scrollToTopBtn.style.display = 'flex';
        scrollToTopBtn.style.justifyContent = 'center';
        scrollToTopBtn.style.alignItems = 'center';
        scrollToTopBtn.style.cursor = 'pointer';
        scrollToTopBtn.style.boxShadow = '0 2px 5px rgba(0,0,0,0.3)';
        scrollToTopBtn.style.zIndex = '1000';
        scrollToTopBtn.style.opacity = '0';
        scrollToTopBtn.style.transition = 'opacity 0.3s, transform 0.3s';

        document.body.appendChild(scrollToTopBtn);

        scrollToTopBtn.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                scrollToTopBtn.style.opacity = '1';
                scrollToTopBtn.style.transform = 'translateY(0)';
            } else {
                scrollToTopBtn.style.opacity = '0';
                scrollToTopBtn.style.transform = 'translateY(10px)';
            }
        });
    }
});