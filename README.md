# Laravel Response Cache additions

[![Latest Version on Packagist](https://img.shields.io/packagist/v/deniztezcan/laravel-responsecache-additions.svg?style=flat-square)](https://packagist.org/packages/deniztezcan/laravel-responsecache-additions)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/deniztezcan/laravel-responsecache-additions.svg?style=flat-square)](https://packagist.org/packages/deniztezcan/laravel-responsecache-additions)

Additions to Spatie's speed up a Laravel app by caching the entire response package so that Mobile and Desktop visitors view different websites.

## Installation
You can install the package via composer:
```bash
composer require deniztezcan/laravel-responsecache-additions
```

The package will automatically register itself.

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Spatie\ResponseCache\ResponseCacheServiceProvider"
```

Replace the following line
```php
'hasher' => \Spatie\ResponseCache\Hasher\DefaultHasher::class,
```

with 
```php
'hasher' => \DenizTezcan\ResponseCache\Hasher\MobileHasher::class,
```

This will make sure Mobile and Desktop visitors view different websites. If you want to make sure a specific area of the website get's replaced by a live version please change:
```php
'replacers' => [
    \Spatie\ResponseCache\Replacers\CsrfTokenReplacer::class,
],
```

with your own replacer, for instance located in `App\Replacers\FooReplacer`
```php
'replacers' => [
    \Spatie\ResponseCache\Replacers\CsrfTokenReplacer::class,
    \App\Replacers\FooReplacer::class,
],
```

The `FooReplacer` can consists of the following
```php
<?php

namespace App\Replacers;

use DenizTezcan\ResponseCache\Replacers\BladeFilesReplacer;

class FooReplacer implements BladeFilesReplacer
{
	protected string | array $htmlTag = 'fake-html-tag'; // html tag without the <> in string or array format
    protected string | array $realTimeView = 'partials.fake-blade-loc'; // blade path string or array format
}
```

this will replace the content of the <fake-html-tag></fake-html-tag> with the on load view renderings of the file `partials.fake-blade-loc`.