# Alt Three Bus

An improved command bus for Laravel 5.2+.


## Installation

Either [PHP](https://php.net) 5.5+ or [HHVM](http://hhvm.com) 3.6+ are required.

To get the latest version of Alt Three Bus, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require alt-three/bus
```

Instead, you may of course manually update your require block and run `composer update` if you so choose:

```json
{
    "require": {
        "alt-three/bus": "^1.0"
    }
}
```

Once Alt Three Bus is installed, you need to replace the original service provider. Open up `config/app.php` and replace `Illuminate\Bus\BusServiceProvider` with `AltThree\Bus\BusServiceProvider`.


## Security

If you discover a security vulnerability within this package, please e-mail us at support@alt-three.com. All security vulnerabilities will be promptly addressed.


## License

Alt Three Bus is licensed under [The MIT License (MIT)](LICENSE).
