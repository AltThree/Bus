![Alt Three Bus](https://user-images.githubusercontent.com/2829600/71490847-0de16e00-2825-11ea-8897-b42ef351832e.png)

<p align="center">
<a href="https://github.com/AltThree/Bus/actions?query=workflow%3ATests"><img src="https://img.shields.io/github/workflow/status/AltThree/Bus/Tests?label=Tests&style=flat-square" alt="Build Status"></img></a>
<a href="https://github.styleci.io/repos/48430841"><img src="https://github.styleci.io/repos/48430841/shield" alt="StyleCI Status"></img></a>
<a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-brightgreen?style=flat-square" alt="Software License"></img></a>
<a href="https://packagist.org/packages/alt-three/bus"><img src="https://img.shields.io/packagist/dt/alt-three/bus?style=flat-square" alt="Packagist Downloads"></img></a>
<a href="https://github.com/AltThree/Bus/releases"><img src="https://img.shields.io/github/release/AltThree/Bus?style=flat-square" alt="Latest Version"></img></a>
</p>


## Installation

Alt Three Bus is an improved command bus for Laravel. This version requires [PHP](https://php.net) 7.1-8.0, and supports Laravel 5.5-8. Simply require the package using [Composer](https://getcomposer.org):

```bash
$ composer require alt-three/bus:^4.5
```

This package **will not** be picked up by Laravel's automatic package discovery. Once installed, you need to **remove** the `Illuminate\Bus\BusServiceProvider` and **replace** it with the `AltThree\Bus\BusServiceProvider` service provider in your `config/app.php`.


## Security

Our full security policy is available to read [here](https://github.com/AltThree/Bus/security/policy).


## License

Alt Three Bus is licensed under [The MIT License (MIT)](LICENSE).
