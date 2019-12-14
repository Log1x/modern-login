<?php

/**
 * Plugin Name: Modern Login
 * Plugin URI:  https://github.com/log1x/modern-login
 * Description: A whitelabeled and modernized wp-login.php
 * Version:     1.0.0
 * Author:      Brandon Nifong
 * Author URI:  https://github.com/log1x
 * Licence:     MIT
 */

add_action('init', new class
{
    /**
     * The plugin URI.
     *
     * @var string
     */
    protected $uri;

    /**
     * The plugin path.
     *
     * @var string
     */
    protected $path;

    /**
     * The login color palette.
     *
     * @var array
     */
    protected $colors = [
        'text' => '#fff',
        'brand' => '#0073aa',
        'trim' => '#181818',
        'trim-alt' => '#282828',
    ];

    /**
     * Invoke the plugin.
     *
     * @return void
     */
    public function __invoke()
    {
        $this->uri = plugin_dir_url(__FILE__) . 'public';
        $this->path = plugin_dir_path(__FILE__) . 'public';

        $this->colors = array_merge(
            $this->colors,
            apply_filters('login_color_palette', $this->colors)
        );

        $this->injectColors();
        $this->enqueue();
    }

    /**
     * Enqueue the login scripts.
     *
     * @return void
     */
    public function enqueue()
    {
        add_action('login_enqueue_scripts', function () {
            wp_enqueue_style('modern-login/login.css', $this->asset('/css/login.css'), false, null);
        }, 100);
    }

    /**
     * Resolve the URI for an asset using the manifest.
     *
     * @return string
     */
    public function asset($asset = '', $manifest = 'mix-manifest.json')
    {
        if (! file_exists($manifest = $this->path . $manifest)) {
            return $this->uri . $asset;
        }

        $manifest = json_decode(file_get_contents($manifest), true);

        return $this->uri . ($manifest[$asset] ?? $asset);
    }

    /**
     * Inject the color properties into the login head.
     *
     * @param  array $colors
     * @return string
     */
    public function injectColors($colors = [])
    {
        if (! is_array($this->colors)) {
            return;
        }

        foreach ($this->colors as $label => $value) {
            $colors[] = "--login-{$label}: {$value};";
        }

        $this->colors = implode(' ', $colors);

        add_filter('login_head', function () {
            echo "<style>:root { {$this->colors} }</style>", PHP_EOL;
        });
    }
});
