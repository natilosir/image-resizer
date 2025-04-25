<div class="ds-markdown ds-markdown--block" style="--ds-md-zoom: 1.143;">
    <h1>WP Image Resizer &amp; Optimizer - Usage Guide</h1>
    <h2>Plugin Overview</h2>
    <p class="ds-markdown-paragraph">This WordPress plugin automatically resizes and optimizes uploaded images to improve website performance. It can also process existing images in your media library.</p>
    <h2>Installation</h2>
        <h3>Method 1: Composer Installation (Recommended)</h3>
        <ol start="1">
            <li><p class="ds-markdown-paragraph">Run the following command in your WordPress root directory:</p>
                <div class="md-code-block md-code-block-dark">
                    <div class="md-code-block-banner-wrap">
                        <div class="md-code-block-banner md-code-block-banner-lite">
                            <div class="_121d384">
                            </div>
                        </div>
                    </div>
                    <pre><span class="token function">composer</span> require natilosir/image-resizer</pre>
                </div>
            </li>
            <li><p class="ds-markdown-paragraph">After installation, execute the move script:</p>
                <div class="md-code-block md-code-block-dark">
                    <div class="md-code-block-banner-wrap">
                    </div>
                    <pre>php vendor/natilosir/image-resizer/move-to-plugins.php</pre>
                </div>
            </li>
        </ol>
        <h3>Method 2: Manual Installation</h3>
        <ol start="1">
            <li><p class="ds-markdown-paragraph">Download the plugin ZIP file</p></li>
            <li>
                <p class="ds-markdown-paragraph">Upload it to your WordPress plugins directory (<code>wp-content/plugins/</code>)
                </p></li>
            <li>
                <p class="ds-markdown-paragraph">Activate the plugin through the WordPress admin panel under "Plugins"</p>
            </li>
        </ol>
    <h2>Configuration</h2>
    <ol start="1">
        <li><p class="ds-markdown-paragraph">Go to
            <strong>Tools &gt; Image Resizer</strong> in your WordPress admin panel</p></li>
        <li><p class="ds-markdown-paragraph">Configure the settings:</p>
            <ul>
                <li><p class="ds-markdown-paragraph">
                    <strong>Maximum Width</strong>: Set the maximum width for uploaded images (default: 1920px)</p></li>
                <li><p class="ds-markdown-paragraph">
                    <strong>Maximum Height</strong>: Set the maximum height for uploaded images (default: 1080px)</p>
                </li>
                <li><p class="ds-markdown-paragraph">
                    <strong>Image Quality</strong>: Set the compression quality (1-100, default: 85)</p></li>
                <li><p class="ds-markdown-paragraph">
                    <strong>Auto Resize on Upload</strong>: Enable/disable automatic resizing of new uploads</p></li>
            </ul>
        </li>
        <li><p class="ds-markdown-paragraph">Click "Save Changes"</p></li>
    </ol>
    <h2>Features</h2>
    <h3>Automatic Processing</h3>
    <p class="ds-markdown-paragraph">When enabled, the plugin will automatically:</p>
    <ul>
        <li><p class="ds-markdown-paragraph">Resize uploaded images to your specified dimensions</p></li>
        <li><p class="ds-markdown-paragraph">Optimize images with your chosen quality setting</p></li>
        <li><p class="ds-markdown-paragraph">Maintain the original aspect ratio</p></li>
    </ul>
    <h3>Manual Processing</h3>
    <p class="ds-markdown-paragraph">To process all existing images in your media library:</p>
    <ol start="1">
        <li><p class="ds-markdown-paragraph">Go to <strong>Tools &gt; Image Resizer</strong></p></li>
        <li><p class="ds-markdown-paragraph">Scroll to the "Manual Image Processing" section</p></li>
        <li><p class="ds-markdown-paragraph">Click the "Process All Images" button</p></li>
        <li>
            <p class="ds-markdown-paragraph">The plugin will show you how many images were processed and how many were skipped</p>
        </li>
    </ol>
    <h2>Supported Image Formats</h2>
    <p class="ds-markdown-paragraph">The plugin works with:</p>
    <ul>
        <li><p class="ds-markdown-paragraph">JPEG/JPG</p></li>
        <li><p class="ds-markdown-paragraph">PNG</p></li>
        <li><p class="ds-markdown-paragraph">GIF</p></li>
        <li><p class="ds-markdown-paragraph">WebP</p></li>
    </ul>
    <h2>Notes</h2>
    <ul>
        <li><p class="ds-markdown-paragraph">The plugin uses WordPress's built-in image editor for resizing</p></li>
        <li><p class="ds-markdown-paragraph">Original images are replaced with the optimized versions</p></li>
        <li><p class="ds-markdown-paragraph">Thumbnails are automatically regenerated after processing</p></li>
        <li>
            <p class="ds-markdown-paragraph">Higher quality settings result in larger file sizes but better image quality</p>
        </li>
    </ul>
    <h2>Troubleshooting</h2>
    <p class="ds-markdown-paragraph">If images aren't being processed:</p>
    <ol start="1">
        <li><p class="ds-markdown-paragraph">Verify the plugin is activated</p></li>
        <li><p class="ds-markdown-paragraph">Check that "Auto Resize on Upload" is enabled in settings</p></li>
        <li><p class="ds-markdown-paragraph">Ensure your server has the required PHP extensions for image processing</p>
        </li>
        <li><p class="ds-markdown-paragraph">Check your WordPress uploads directory permissions</p></li>
    </ol>
    <p class="ds-markdown-paragraph">For optimal results, we recommend quality settings between 70-90 for the best balance of quality and file size.</p>
</div>