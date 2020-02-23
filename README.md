![Alt Three Bus](https://user-images.githubusercontent.com/2829600/71490847-0de16e00-2825-11ea-8897-b42ef351832e.png)

<p align="center">
<a href="https://github.styleci.io/repos/48430841"><img src="https://github.styleci.io/repos/48430841/shield" alt="StyleCI Status"></img></a>
<a href="https://github.com/AltThree/Bus/actions?query=workflow%3ATests"><img src="https://img.shields.io/github/workflow/status/AltThree/Bus/Tests?style=flat-square" alt="Build Status"></img></a>
<a href="https://scrutinizer-ci.com/g/AltThree/Bus/code-structure"><img src="https://img.shields.io/scrutinizer/coverage/g/AltThree/Bus.svg?style=flat-square" alt="Coverage Status"></img></a>
<a href="https://scrutinizer-ci.com/g/AltThree/Bus"><img src="https://img.shields.io/scrutinizer/g/AltThree/Bus.svg?style=flat-square" alt="Quality Score"></img></a>
<a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Software License"></img></a>
<a href="https://github.com/AltThree/Bus/releases"><img src="https://img.shields.io/github/release/AltThree/Bus.svg?style=flat-square" alt="Latest Version"></img></a>
</p>


## Installation

Alt Three Bus is an improved command bus for Laravel. This version requires [PHP](https://php.net) 7.1-7.4, and supports Laravel 5.5-7. Simply require the package using [Composer](https://getcomposer.org):

```bash
$ composer require alt-three/bus
```

This package **will not** be picked up by Laravel's automatic package discovery. Once installed, you need to **remove** the `Illuminate\Bus\BusServiceProvider` and **replace** it with the `AltThree\Bus\BusServiceProvider` service provider in your `config/app.php`.


## Security

Our full security policy is available to read [here](https://github.com/AltThree/Bus/security/policy).


## License

Alt Three Bus is licensed under [The MIT License (MIT)](LICENSE).
