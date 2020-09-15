<?php

/**
 * Plugin Name: Modern Login
 * Plugin URI:  https://github.com/log1x/modern-login
 * Description: A whitelabeled and modernized wp-login.php
 * Version:     1.0.7
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

        foreach ($this->colors as $label => $color) {
            $this->colors[$label . '-invert'] = $this->invert($color);
        }

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

    /**
     * Invert a hexidecimal color to black or white depending on the luminance.
     *
     * The final value is compared to the following formula:
     *   ↪ sqrt(1.05 * 0.05) - 0.05 = 0.17912878474779
     *
     * @param  string $hex
     * @return string
     */
    public function invert($hex)
    {
        $expression = [
            3 => '/^([0-9a-fA-F])([0-9a-fA-F])([0-9a-fA-F])$/',
            4 => '/^#([0-9a-fA-F])([0-9a-fA-F])([0-9a-fA-F])$/',
            6 => '/^([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})$/',
            7 => '/^#([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})$/',
        ];

        $length = strlen($hex);
        $regex = $expression[$length] ?? false;
        $match = [];

        if (! $regex || preg_match($regex, $hex, $match) !== 1) {
            return '#fff';
        }

        $rgb = $length > 4 ? [
            (int) hexdec($match[1]),
            (int) hexdec($match[2]),
            (int) hexdec($match[3]),
        ] : [
            (int) hexdec($match[1] . $match[1]),
            (int) hexdec($match[2] . $match[2]),
            (int) hexdec($match[3] . $match[3]),
        ];

        foreach ($rgb as $i => $channel) {
            $coef = $channel / 255;
            $levels[$i] = $coef <= 0.03928 ? $coef / 12.92 : (($coef + 0.055) / 1.055) ** 2.4;
        }

        $levels = 0.2126 * $levels[0] + 0.7152 * $levels[1] + 0.0722 * $levels[2];

        return $levels > 0.17912878474779 ? '#111' : '#fff';
    }
});
