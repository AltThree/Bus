# Alt Three Bus

An improved command bus for Laravel 5.


## Installation

This version requires [PHP](https://php.net) 7.1 - 7.3, and supports Laravel 5.5 - 5.8 only.

To get the latest version, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require alt-three/bus
```

This package **will not** be picked up by Laravel's automatic package discovery. Once installed, you need to **remove** the `Illuminate\Bus\BusServiceProvider` and **replace** it with the `AltThree\Bus\BusServiceProvider` service provider in your `config/app.php`.


## Security

Our full security policy is available to read [here](https://github.com/AltThree/Bus/security/policy).


## License

Alt Three Bus is licensed under [The MIT License (MIT)](LICENSE).
