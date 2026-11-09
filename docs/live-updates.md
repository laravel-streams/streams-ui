# Live updates

Both features are optional. Nothing breaks when Laravel Echo is absent.

## refreshOn

```php
Container::for($this)->refreshOn('work', 'work.changed');
$table->refreshOn('work', ['work.changed'], pollSeconds: 10, private: true);
```

With `window.Echo` defined, the component subscribes to the channel and calls `$wire.$refresh()` on each listed event. Without Echo it polls every `pollSeconds` (0 disables polling).

## Bootstrap guard

`layouts/partials/assets.blade.php` defines `window.streamsRefreshOn` and `window.streamsLogTail` once. Mounting happens from Alpine `x-init`, so it only runs after Alpine starts, and it checks `window.Echo` at mount time.

## LogTail

```php
LogTail::make('run-log')
    ->source(fn () => $this->lines())   // full list, oldest first
    ->cap(500)
    ->refreshOn('run.1', 'log.line');
```

The server sends the last `cap` lines plus their absolute offset. The client appends only lines it has not rendered, trims the oldest beyond `cap`, and keeps the view scrolled to the bottom until the user scrolls up.
