document.addEventListener('DOMContentLoaded', function() {

    const featureButtons = document.querySelectorAll('.features-section .btn, .features-section .card-title a');


    featureButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();


            const featureUrl = this.getAttribute('href');


            const demoSection = document.getElementById('demo-previews-section');
            if (demoSection) {
                demoSection.scrollIntoView({
                    behavior: 'smooth'
                });
            }


            const demoContent = document.getElementById('demo-content');
            demoContent.innerHTML = '<div class="col-12 text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';


            fetch(featureUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(html => {

                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');


                    const contentSection = doc.querySelector('.demo-section, .demo-previews-section');

                    if (contentSection) {

                        demoContent.innerHTML = contentSection.innerHTML;


                        const scripts = contentSection.querySelectorAll('script');
                        scripts.forEach(script => {
                            const newScript = document.createElement('script');
                            if (script.src) {
                                newScript.src = script.src;
                            } else {
                                newScript.textContent = script.textContent;
                            }
                            document.body.appendChild(newScript).parentNode.removeChild(newScript);
                        });
                    } else {
                        throw new Error('Could not find content section in fetched HTML');
                    }


                    const featureTitleElement = this.closest('.card').querySelector('.card-title');
                    const currentFeatureElement = document.getElementById('current-feature-title');
                    if (featureTitleElement && currentFeatureElement) {
                        currentFeatureElement.textContent = featureTitleElement.textContent;
                    }
                })
                .catch(error => {
                    console.error('Error loading feature:', error);
                    demoContent.innerHTML = '<div class="col-12"><div class="alert alert-danger">Error loading feature. Please try again.</div></div>';
                });
        });
    });
});