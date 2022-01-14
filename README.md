# Laravel external feed parser.

![Packagist License](https://img.shields.io/packagist/l/yaroslawww/laravel-external-feed-parser?color=%234dc71f)
[![Packagist Version](https://img.shields.io/packagist/v/yaroslawww/laravel-external-feed-parser)](https://packagist.org/packages/yaroslawww/laravel-external-feed-parser)
[![Total Downloads](https://img.shields.io/packagist/dt/yaroslawww/laravel-external-feed-parser)](https://packagist.org/packages/yaroslawww/laravel-external-feed-parser)
[![Build Status](https://scrutinizer-ci.com/g/yaroslawww/laravel-external-feed-parser/badges/build.png?b=master)](https://scrutinizer-ci.com/g/yaroslawww/laravel-external-feed-parser/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/yaroslawww/laravel-external-feed-parser/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/yaroslawww/laravel-external-feed-parser/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yaroslawww/laravel-external-feed-parser/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yaroslawww/laravel-external-feed-parser/?branch=master)

"Template method" package to parse external feed.

## Installation

Install the package via composer:

```shell
composer require yaroslawww/laravel-external-feed-parser
```

Optionally you can publish the config file with:

```shell
php artisan vendor:publish --provider="ExternalFeedParser\ServiceProvider" --tag="config"
```

## Usage

Add config to `config/services.php` or `config/external-feed-parser.php`.

```php
'jobs-feeds' => [
    'foobar' => [
        'pull' => [
            'class'   => \ExternalFeedParser\Pull\XmlFeedPull::class,
            'options' => [
                'url'        => 'https://www.foobar.co.uk/rssfeed/example.aspx',
                'listingKey' => 'baz',
            ],
        ],
        'convert' => [
            'class'   => \ExternalFeedParser\Converters\SimpleConverter::class,
            'options' => [
                'entityClass' => \ExternalFeedParser\Entity\ExternalEntity::class,
            ],
        ],
    ],
],
```

```php
FeedParser::provider('foobar')
    ->parse()
    ->each(function (ExternalEntity $entity) {
        $entity->get('baz')
    });
```

## Credits

- [![Think Studio](https://yaroslawww.github.io/images/sponsors/packages/logo-think-studio.png)](https://think.studio/) 
