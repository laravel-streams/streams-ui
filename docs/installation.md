---
title: Installation
description: 'How to install and configure Streams UI in your Laravel application.'
sort_order: 1
category: getting-started
status: live
---

# Installation

Streams UI requires a Laravel application with Laravel Streams Core already installed. If you haven't installed Streams Core yet, please refer to the [Streams Core documentation](https://streams.dev/docs/core) first.

## Requirements

- PHP 8.1 or higher
- Laravel 10.0 or higher
- Laravel Streams Core 2.0 or higher
- Livewire 3.0 or higher

## Installing via Composer

Install Streams UI using Composer:

```bash
composer require streams/ui
```

The package will automatically register its service provider via Laravel's package auto-discovery.

## Publishing Assets

Streams UI includes frontend assets (CSS, JavaScript, images) that need to be published to your public directory:

```bash
php artisan vendor:publish --tag=laravel-assets --provider="Streams\Ui\UiServiceProvider"
```

This will publish assets to `public/vendor/streams/ui/`.

### Publishing Configuration

If you need to customize the configuration, publish the config file:

```bash
php artisan vendor:publish --tag=config --provider="Streams\Ui\UiServiceProvider"
```

This will create `config/streams/ui.php`.

### Publishing Views

To customize the Blade views, publish them to your application:

```bash
php artisan vendor:publish --tag=ui --provider="Streams\Ui\UiServiceProvider"
```

This will publish views to `resources/views/vendor/ui/`.

### Publishing Streams

To publish example stream definitions:

```bash
php artisan vendor:publish --tag=laravel-streams --provider="Streams\Ui\UiServiceProvider"
```

This will publish stream definitions to `streams/`.

## Tailwind CSS Configuration

Streams UI is built with Tailwind CSS. You'll need to ensure your Tailwind configuration includes the Streams UI paths for purging:

```js
// tailwind.config.js
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './vendor/streams/ui/resources/**/*.blade.php',
        './vendor/streams/ui/resources/**/*.js',
    ],
    theme: {
        extend: {},
    },
    plugins: [],
}
```

If you're using the Streams UI Tailwind preset, you can extend it in your configuration:

```js
// tailwind.config.js
import preset from './vendor/streams/ui/tailwind.preset.js'

export default {
    presets: [preset],
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './vendor/streams/ui/resources/**/*.blade.php',
        './vendor/streams/ui/resources/**/*.js',
    ],
}
```

## Asset Compilation

After configuring Tailwind, compile your assets:

```bash
npm run build
```

Or for development with hot reloading:

```bash
npm run dev
```

## Livewire Configuration

Streams UI uses Livewire 3 for reactive components. Ensure Livewire is properly configured in your application. The package automatically configures Livewire's persistent middleware for panel support.

No additional Livewire configuration is required, but you may want to customize Livewire settings in `config/livewire.php` if needed.

## Next Steps

Once installed, you're ready to create your first panel. Continue to the next section to learn how to create panels, pages, and resources.

### Quick Start

Here's a minimal example to get you started. Create a panel in `app/Panels/AdminPanel.php`:

```php
<?php

namespace App\Panels;

use Streams\Ui\Builders\Panels\Panel;

class AdminPanel extends Panel
{
    protected string $id = 'admin';
    
    public function configure(): void
    {
        $this->brandName('My Admin');
    }
}
```

Register it in a service provider:

```php
use App\Panels\AdminPanel;
use Streams\Ui\Support\Facades\UI;

public function boot()
{
    UI::register(AdminPanel::make());
}
```

Access your panel at `/admin` (or whatever path you configure).

## Troubleshooting

### Assets Not Loading

If assets aren't loading, ensure:
1. You've published assets with `php artisan vendor:publish --tag=laravel-assets`
2. The `public/vendor/streams/ui` directory exists
3. Your web server has read permissions for the directory

### Styles Not Applied

If Tailwind styles aren't working:
1. Verify your `tailwind.config.js` includes the Streams UI content paths
2. Run `npm run build` or `npm run dev` to compile assets
3. Clear your browser cache

### Livewire Components Not Working

If Livewire components aren't reactive:
1. Ensure Livewire assets are published: `php artisan livewire:publish --assets`
2. Check that Livewire scripts are included in your layout
3. Verify Livewire is properly installed: `composer require livewire/livewire`

### Permission Errors

If you encounter permission errors:
```bash
sudo chown -R $USER:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

## Upgrading

When upgrading Streams UI, always republish the assets:

```bash
composer update streams/ui
php artisan vendor:publish --tag=laravel-assets --provider="Streams\Ui\UiServiceProvider" --force
npm run build
```

Clear your application cache:

```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```
