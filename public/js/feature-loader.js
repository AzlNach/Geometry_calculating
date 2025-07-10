document.addEventListener('DOMContentLoaded', function() {
    const featureButtons = document.querySelectorAll('.features-section .btn, .features-section .card-title a');

    featureButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            let pagePath = this.getAttribute('href'); // This will be like "/geometry-calculations.php"

            // Ensure pagePath starts with a slash if it's a local path
            if (!pagePath.startsWith('/') && !pagePath.startsWith('http')) {
                pagePath = '/' + pagePath;
            }

            // Construct the URL to target index.php with a query parameter
            const fetchUrl = `/index.php?page=${encodeURIComponent(pagePath)}`;

            const demoSection = document.getElementById('demo-previews-section');
            if (demoSection) {
                demoSection.scrollIntoView({
                    behavior: 'smooth'
                });
            }

            const demoContent = document.getElementById('demo-content');
            demoContent.innerHTML = '<div class="col-12 text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';

            // Add AJAX header and proper URL handling
            fetch(fetchUrl, { // Use the new fetchUrl
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        console.error('Failed to fetch:', fetchUrl, 'Status:', response.status);
                        throw new Error(`Network response was not ok: ${response.status}`);
                    }
                    return response.text();
                })
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    const contentSection = doc.querySelector('.demo-section, .demo-previews-section');

                    if (contentSection) {
                        demoContent.innerHTML = contentSection.innerHTML;

                        // Execute scripts with better error handling
                        const scripts = contentSection.querySelectorAll('script');
                        scripts.forEach(script => {
                            try {
                                const newScript = document.createElement('script');
                                if (script.src) {
                                    newScript.src = script.src;
                                } else {
                                    newScript.textContent = script.textContent;
                                }
                                document.body.appendChild(newScript);
                                console.log('Script executed successfully');
                            } catch (scriptError) {
                                console.error('Error executing script:', scriptError);
                            }
                        });
                    } else {
                        throw new Error('Could not find content section in fetched HTML');
                    }
                })
                .catch(error => {
                    console.error('Error loading feature:', error);
                    demoContent.innerHTML = `
                        <div class="col-12">
                            <div class="alert alert-danger">
                                <h5>Error loading feature</h5>
                                <p>Please try again. If the problem persists, check the console for details.</p>
                                <small>Debug: ${error.message}</small>
                                <br><small>URL: ${featureUrl}</small>
                            </div>
                        </div>
                    `;
                });
            const debugBtn = document.createElement('button');
            debugBtn.textContent = 'Debug Content';
            debugBtn.onclick = () => alert('Current content: ' + demoContent.innerHTML.substring(0, 100) + '...');
            demoContent.prepend(debugBtn);
        });
    });
});