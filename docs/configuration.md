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

#### Publishing Configuration

Use the following command to publish configuration files.

```bash
php artisan vendor:publish --vendor=Streams\\Ui\\UiServiceProvider --tag=config
```

The above command will copy configuration files from their package location to the directory mentioned above so that you can modify them directly and commit them to your version control system.
