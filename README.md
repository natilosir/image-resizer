<div class="ds-markdown ds-markdown--block" style="--ds-md-zoom: 1.143;">
    <h1>Image Resizer for WordPress</h1>
    <p class="ds-markdown-paragraph">A WordPress plugin that automatically resizes uploaded images to specified dimensions while optimizing their quality and reducing file size. The plugin ensures all new uploads are processed according to your configuration.</p>
    <h2>Features</h2>
    <ul>
        <li><p class="ds-markdown-paragraph">Resizes images to configurable dimensions</p></li>
        <li><p class="ds-markdown-paragraph">Optimizes image quality for smaller file sizes</p></li>
        <li><p class="ds-markdown-paragraph">Processes both existing and newly uploaded images</p></li>
        <li><p class="ds-markdown-paragraph">Easy configuration through WordPress settings</p></li>
    </ul>
    <h2>Installation</h2>
    <h3>Method 1: Composer Installation (Recommended)</h3>
    <ol start="1">
        <li><p class="ds-markdown-paragraph">Run the following command in your WordPress root directory:</p></li>
    </ol>
    <div class="md-code-block md-code-block-dark">
        <div class="md-code-block-banner-wrap">
            <div class="md-code-block-banner md-code-block-banner-lite">
                <div class="_121d384"
                <div class="d2a24f03">
                    <div class="efa13877">
                        <div role="button"
                             class="ds-button ds-button--secondary ds-button--borderless ds-button--rect ds-button--m _7db3914"
                             tabindex="0"
                             style="margin-right: 8px; font-size: 13px; height: 28px; padding: 0px 4px; --button-text-color: var(--dsr-text-2);">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <pre><span class="token function">composer</span> require natilosir/image-resizer</pre>
</div>
<ol start="2">
    <li><p class="ds-markdown-paragraph">After installation, execute the move script:</p></li>
</ol>
<div class="md-code-block md-code-block-dark">

    <pre>php vendor/natilosir/image-resizer/move-to-plugins.php</pre>

</div><h3>Method 2: Manual Installation</h3>
<ol start="1">
    <li><p class="ds-markdown-paragraph">Download the plugin ZIP file</p></li>
    <li><p class="ds-markdown-paragraph">Upload it to your WordPress plugins directory (<code>wp-content/plugins/</code>)
    </p></li>
    <li><p class="ds-markdown-paragraph">Activate the plugin through the WordPress admin panel</p></li>
</ol><h2>Configuration</h2>
<ol start="1">
    <li><p class="ds-markdown-paragraph">Navigate to WordPress Admin Dashboard → Settings → Media</p></li>
    <li><p class="ds-markdown-paragraph">Configure your desired image resizing options</p></li>
    <li><p class="ds-markdown-paragraph">Save changes</p></li>
</ol><h2>Usage</h2><p class="ds-markdown-paragraph">Once activated, the plugin will automatically:</p>
<ul>
    <li><p class="ds-markdown-paragraph">Process all newly uploaded images according to your settings</p></li>
    <li><p class="ds-markdown-paragraph">Optionally resize existing images (configuration required)</p></li>
</ul><h2>Requirements</h2>
<ul>
    <li><p class="ds-markdown-paragraph">WordPress 5.0 or higher</p></li>
    <li><p class="ds-markdown-paragraph">PHP 7.4 or higher</p></li>
    <li><p class="ds-markdown-paragraph">GD Library or Imagick extension</p></li>
</ul>