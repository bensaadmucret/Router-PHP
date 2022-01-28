# Router-PHP


[![Build Status](https://app.travis-ci.com/bensaadmucret/mzb-php-router-matcher.svg?branch=main)](https://app.travis-ci.com/bensaadmucret/mzb-php-router-matcher)
[![Coverage Status](https://coveralls.io/repos/github/bensaadmucret/mzb-php-router-matcher/badge.svg?branch=main)](https://coveralls.io/github/bensaadmucret/mzb-php-router-matcher?branch=main)

Requirements
The following versions of PHP are supported by this version.

* PHP 7.2
* PHP 7.3
* PHP 7.4
* PHP 8.0


### Testing
- vendor/bin/phpunit

### You need PHP >= 7.2.0 to use mzb/php-router-matcher but the latest stable version of PHP is recommended.

Composer
Route is available on Packagist and can be installed using Composer:

``` php
composer require mzb/php-router-matcher

```

``` php

<?php declare(strict_types=1);

use Mzb\Router\Router;

require_once __DIR__.'/vendor/autoload.php';


$router = new Router();

router::setNameSpace('Mzb\\Controller\\');

$router->add('GET', '/', 'HomeController@index', 'home');
$router->add('GET', '/about', 'HomeController@about', 'about-us');
$router->add('GET', '/about/:id/:slug', 'AboutController@about', 'about-us');
$router->add('POST', '/about/:id', 'AboutController@about', 'about-us');
$router->add('GET', '/contact', function () { echo 'Contact'; }, 'contact');

```
The router takes all HTTP methods ('get, post, put, delete, patch')