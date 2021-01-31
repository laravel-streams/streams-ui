---
title: Configuration
category: getting_started
intro: 'Streams UI uses Laravel config files and environment variables for application-level settings.'
sort: 2
stage: drafting
enabled: true
---
## Configuration Files

Published configuration files reside in `config/streams/`.

``` files
├── config/streams/
│   └── ui.php
```

### Publishing Configuration

Use the following command to publish configuration files to your project's `config/streams` directory.

```bash
php artisan vendor:publish --vendor=Streams\\Ui\\UiServiceProvider --tag=config
```

### Publishing Streams

Use the following command to publish package streams to your project streams directory.

```bash
php artisan vendor:publish --vendor=Streams\\Ui\\UiServiceProvider --tag=streams
```
