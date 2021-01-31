---
title: Installation
category: getting_started
intro:
enabled: true
---

## Download

Download the Streams UI package using Composer.

```bash
composer require streams/ui
```

You might consider starting with the [Streams starter application](/docs/installation).

## Publish

Use the following command to publish the public assets required for this package.

```bash
php artisan vendor:publish --vendor=Streams\\Ui\\UiServiceProvider --tag=public
```

## Updating

From within your project, use Composer to update individual packages:

```bash
composer update streams/ui --with-dependencies
```

You can, of course, update your entire project using `composer update`.
