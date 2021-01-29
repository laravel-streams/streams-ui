---
title: Installation
category: getting_started
intro:
enabled: true
---

The Streams UI package is added to existing Laravel projects as a dependency by requiring it with Composer.

```bash
composer require streams/ui
```

You might consider starting with the [Streams starter application](/docs/installation).

## Publishing Assets

```bash
php artisan vendor:publish --vendor=Streams\\Ui\\UiServiceProvider --tag=public
```

## Updating

From within your project, use Composer to update individual packages:

```bash
composer update streams/ui --with-dependencies
```

You can, of course, update your entire project using `composer update`.
