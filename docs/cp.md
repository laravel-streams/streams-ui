---
__created_at: 1612057264
__updated_at: 1612057264
title: Control Panel
category: basics
sort: 0
enabled: true
stage: outlining
---
## Introduction

The control panel is an easily configurable administrative tool.

### Configuration

*Control panel theme configuration is currently in development.*

### Responses

The control panel will **automatically** wrap other builder view responses with the `ui::cp` layout *when responses are generated within the control panel URI prefix*.

Both examples are wrapped by the `ui::cp` view layout.

```php
// GET: {cp_prefix}/{example}
use Streams\Core\Support\Facades\Streams;

return Streams::make('example')->table()->response();
```

```php
// GET: random/{example}
use Streams\Core\Support\Facades\Streams;

return Streams::make('example')->table([
    'options.cp_enabled' => true,
])->response();
```

## Components

### Navigation

The primary building blocks of your control panel.

[Navigation](navigation)

### Shortcuts

The basic elements of the control panel topbar.

[Shortcuts](shortcuts)
