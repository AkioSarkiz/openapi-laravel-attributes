# Openapi Laravel Attributes 

This package is needed to create open api documentation for laravel applications.
It is a wrapper around another [package](https://github.com/uderline/openapi-php-attributes).
This package does not form the UI view.

## Installation

You can install the package via composer:

```bash
composer require akisoarkiz/openapi-laravel-attributes
```

## Usage

```bash
php artisan openapi:generate
```

## Overwrite json

If you want to overwrite json you have to implement `\AkioSarkiz\Contacts\TransformerOpenapi` and bind it to AppServiceProvider.

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

- [AkioSarkiz](https://github.com/akiosarkiz)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
