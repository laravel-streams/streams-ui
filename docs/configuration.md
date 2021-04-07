---
title: Configuration
category: getting_started
intro: Configuring the UI.
sort: 2
enabled: true
---

## Configuration Files

Published configuration files reside in `config/streams/`.

``` files
├── config/streams/
│   └── ui.php
```

### Publishing Configuration

Use the following command to publish configuration files.

```bash
php artisan vendor:publish --provider=Streams\\Ui\\StreamsServiceProvider --tag=config
```

The above command will copy configuration files from their package location to the directory mentioned above so that you can modify them directly and commit them to your version control system.

## Configuring the UI

Below are the contents of the published configuration file:

```php
// config/streams/ui.php

return [
    // Waiting
];
```
