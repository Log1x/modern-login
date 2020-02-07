# Modern Login

![Latest Stable Version](https://img.shields.io/packagist/v/log1x/modern-login?style=flat-square)
![Total Downloads](https://img.shields.io/packagist/dt/log1x/modern-login?style=flat-square)

Here lives a simple `mu-plugin` to whitelabel and modernize `wp-login.php`. No admin panels, no bloat – just a simple filter to optionally customize the CSS properties with your color palette.

![Screenshot](https://i.imgur.com/UIbCrSZ.png)

## Requirements

- [PHP](https://secure.php.net/manual/en/install.php) >= 7.1.3
- [Composer](https://getcomposer.org/download/)

## Installation

### Bedrock

Install via Composer:

```bash
$ composer require log1x/modern-login
```

### Manual

Download the release `.zip` and install into `wp-content/plugins`.

## Customization

To customize the color palette, simply pass an array containing one or more of the colors you would like to change to the `login_color_palette` filter:

```php
add_filter('login_color_palette', function () {
    return [
        'brand' => '#0073aa',
        'trim' => '#181818',
        'trim-alt' => '#282828',
    ];
});
```

Text color will automatically be inverted to `#fff` or `#111` determined by the [relative luminance](https://www.w3.org/TR/WCAG20/relative-luminance.xml) of the element's background color.

### Changing the Logo

The logo uses the first letter of the login header text set by WordPress. You can customize this using the [`login_headertext`](https://developer.wordpress.org/reference/hooks/login_headertext/) filter:

```php
/**
 * Change the WordPress login header to the blog name.
 *
 * @return string
 */
add_filter('login_headertext', function () {
    return get_bloginfo('name');
});
```

## Development

Modern Login is built using TailwindCSS and compiled with Laravel Mix.

```bash
$ yarn install
$ yarn run start
```

## Bug Reports

If you discover a bug in Modern Login, please [open an issue](https://github.com/log1x/modern-login/issues).

## Contributing

Contributing whether it be through PRs, reporting an issue, or suggesting an idea is encouraged and appreciated.

## License

Modern Login is provided under the [MIT License](https://github.com/log1x/modern-login/blob/master/LICENSE.md).
