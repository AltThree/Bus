# Alt Three Bus

An improved command bus for Laravel 5.2+. The current release is for Laravel 5.3, while the previous series was for 5.2 or 5.3.0-RC1 and earlier.


## Installation

[PHP](https://php.net) 5.6+ is required.

To get the latest version of Alt Three Bus, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require alt-three/bus
```

Instead, you may of course manually update your require block and run `composer update` if you so choose:

```json
{
    "require": {
        "alt-three/bus": "^2.0"
    }
}
```

Once Alt Three Bus is installed, you need to replace the original service provider. Open up `config/app.php` and replace `Illuminate\Bus\BusServiceProvider` with `AltThree\Bus\BusServiceProvider`.


## Security

If you discover a security vulnerability within this package, please e-mail us at support@alt-three.com. All security vulnerabilities will be promptly addressed.


## License

Alt Three Bus is licensed under [The MIT License (MIT)](LICENSE).
