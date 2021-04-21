---
title: Installation
category: getting_started
intro:
enabled: true
---

## Downloading

This package is added to existing Laravel projects as a dependency by requiring it with Composer.

```bash
composer require streams/ui
```

Streams UI comes pre-configured with the [Streams starter application](/docs/installation).

### Publishing Assets

Use the following command to publish public assets for this package.

```bash
php artisan vendor:publish --provider=Streams\\Ui\\UiServiceProvider --tag=public
```

The above command will copy public assets from their package location to the `public/vendor` directory.

## Updating

From within your project, use Composer to update this individual package:

```bash
composer update streams/ui --with-dependencies
```

You can also update your entire project using `composer update`.
