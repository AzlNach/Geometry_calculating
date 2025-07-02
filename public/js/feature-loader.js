document.addEventListener('DOMContentLoaded', function() {
    // Get all feature buttons
    const featureButtons = document.querySelectorAll('.features-section .btn, .features-section .card-title a');

    // Add click event listener to each button
    featureButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            // Get the feature URL
            const featureUrl = this.getAttribute('href');

            // Scroll to demo section
            const demoSection = document.getElementById('demo-previews-section');
            if (demoSection) {
                demoSection.scrollIntoView({
                    behavior: 'smooth'
                });
            }

            // Show loading indicator
            const demoContent = document.getElementById('demo-content');
            demoContent.innerHTML = '<div class="col-12 text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';

            // Fetch the feature content
            fetch(featureUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(html => {
                    // Extract only the content we want from the response
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    // Find the main content section, regardless of its specific class
                    const contentSection = doc.querySelector('.demo-section, .demo-previews-section');

                    if (contentSection) {
                        // Update the demo content
                        demoContent.innerHTML = contentSection.innerHTML;

                        // Find and execute any scripts within the loaded content
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

                    // Update page title to reflect current feature
                    const featureTitleElement = this.closest('.card').querySelector('.card-title');
                    const currentFeatureElement = document.getElementById('current-feature-title'); // Assuming you have an element with this ID
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