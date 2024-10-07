# Palette

[![Latest Version on Packagist](https://img.shields.io/packagist/v/awcodes/palette.svg?style=flat-square)](https://packagist.org/packages/awcodes/palette)
[![Total Downloads](https://img.shields.io/packagist/dt/awcodes/palette.svg?style=flat-square)](https://packagist.org/packages/awcodes/palette)

<img src="https://res.cloudinary.com/aw-codes/image/upload/v1725039348/plugins/palette/awcodes-palette.jpg" alt="screenshots of palette in a filament panel" width="1200" height="auto" class="filament-hidden" style="width: 100%;" />

A color picker field for Filament Forms that uses preset color palettes.

## Installation

You can install the package via composer:

```bash
composer require awcodes/palette
```

> [!IMPORTANT]
> If you have not set up a custom theme and are using Filament Panels follow the instructions in the [Filament Docs](https://filamentphp.com/docs/3.x/panels/themes#creating-a-custom-theme) first. The following applies to both the Panels Package and the standalone Forms package.

Add the plugin's views to your `tailwind.config.js` file.

```js
content: [
    './vendor/awcodes/palette/resources/views/**/*.blade.php',
]
```

Rebuild your custom theme.

```sh
npm run build
```

## Config

The plugin will work without publishing the config, but should you need to change any of the default settings you can publish the config file with the following Artisan command:

```bash
php artisan vendor:publish --tag="palette-config"
```

## Preparing your model

By default, Palette will store the selected color in your db as an array of data. Because of this you must cast the column in your model as `array` or `json`.

```php
protected $casts = [
    'content' => 'array', // or 'json'
];
```

The stored content will take the following shape:

```php
[
    'key' => 'primary',
    'property' => '--primary-500',
    'label' => 'Primary',
    'type' => 'rgb',
    'value' => '238, 246, 213',
]
```

### Storing the data as the color's key

Should you prefer to store only the key for the color you can do so either by using the `storeAsKey()` modifier on the `ColorPicker` or `ColorPickerSelect` fields or globally via the `palette.php` config file.

```php
use Awcodes\Palette\Forms\Components\ColorPicker;
use Filament\Support\Colors\Color;

ColorPicker::make('color')
    ->storeAsKey(),
```

## Color Picker Field

Simply add the field to your form using the `ColorPicker` field and pass in an array of Filament Color objects.

Should you need to include black and white in your color palette, you can use the `withWhite` and `withBlack` methods. This will include black and white at the end of the color options. You can also use the 'swap' argument to swap out the hex value used for black and white.

***Note: Shades only work with Filament Color objects*** 

```php
use Awcodes\Palette\Forms\Components\ColorPicker;
use Filament\Support\Colors\Color;

ColorPicker::make('color')
    ->colors([
        'indigo' => Color::Indigo
        'badass' => Color::hex('#bada55'),
        'salmon' => '#fa8072',
        'bg-gradient-secondary' => 'bg-gradient-secondary'
    ])
    ->shades([
        'badass' => 300
    ])
    ->size('sm') // optional 'xs', 'sm', 'md', 'lg', 'xl'
    ->withBlack(swap: '#111111')
    ->withWhite(swap: '#f5f5f5'),
```

## Color Picker Select

Simply add the field to your form using the `ColorPickerSelect` field and pass in an array of Filament Color objects.

Should you need to include black and white in your color palette, you can use the `withWhite` and `withBlack` methods. This will include black and white at the end of the color options. You can also use the 'swap' argument to swap out the hex value used for black and white.

***Note: Shades only work with Filament Color objects***

```php
use Awcodes\Palette\Forms\Components\ColorPickerSelect;
use Filament\Support\Colors\Color;

ColorPickerSelect::make('color')
    ->colors([
        'indigo' => Color::Indigo
        'badass' => Color::hex('#bada55'),
        'salmon' => '#fa8072',
        'bg-gradient-secondary' => 'bg-gradient-secondary'
    ])
    ->shades([
        'badass' => 300
    ])
    ->withBlack(swap: '#111111')
    ->withWhite(swap: '#f5f5f5'),
```

## Color Entry

Simply add the `ColorEntry` to your infolist schema.

```php
use Awcodes\Palette\Infolists\Components\ColorEntry;

ColorEntry::make('color')
    ->size('sm') // optional 'xs', 'sm', 'md', 'lg', 'xl'
```

## Style Hook Classes

Available classes for css customizations on the ColorPicker:

- for the main container: `palette-color-picker`
- for items: `palette-color-picker-item`
- for active/selected item: `palette-color-picker-item-active`

Available classes for css customizations on the ColorEntry:

- for the main container: `palette-entry-item`

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Adam Weston](https://github.com/awcodes)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
