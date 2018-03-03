# Alt Three Bus

An improved command bus for Laravel 5.


## Installation

This version requires [PHP](https://php.net) 7.1 or 7.2, and supports Laravel 5.5 or 5.6.

To get the latest version, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require alt-three/bus
```

This package **will not** be picked up by Laravel's automatic package discovery. Once installed, you need to **remove** the `Illuminate\Bus\BusServiceProvider` and **replace** it with the `AltThree\Bus\BusServiceProvider` service provider in your `config/app.php`.


## Security

If you discover a security vulnerability within this package, please e-mail us at support@alt-three.com. All security vulnerabilities will be promptly addressed.


## License

Alt Three Bus is licensed under [The MIT License (MIT)](LICENSE).
