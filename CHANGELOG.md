# Changelog

## Unreleased

### Added

- `refreshOn($channel, $events, $pollSeconds = 5, $private = false)` on `Container` and `Table`. Re-renders the Livewire component when a broadcast arrives via `window.Echo`; polls when Echo is absent. See `docs/live-updates.md`.
- `Streams\Ui\Widgets\LogTail`: append-only log widget with a line cap and auto-scroll pinning.
- Guarded Echo/Alpine bootstrap in `layouts/partials/assets.blade.php` (no-op without Echo).
