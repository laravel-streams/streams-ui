# Changelog

## Unreleased

### Added

- `Table::defaultFilters(array $values)` and `Filter::default($value)` seed filter values on first load. Resetting filters clears them.
- `MountableAction::modalForm(Form|array|Closure $form)` attaches a form to the action modal. Submitting it (Enter or button) validates the form, runs the mounted action and closes the modal.
- `Form::handle()` default implementation (validate, then `callMountedAction`) and `Form::submitsMountedAction()`. Existing `handle()` overrides keep working.

- `Resource::$tabs`, `getTabs()`, `getBreadcrumbs()`: declarative tabs with route-derived active state and a breadcrumb chain.
- `Card::table($table, $rowActions)`: host a Table in a Card; row `MountableAction`s mount with the entry, no `UiActions::register` call.
- `Display` and `Display\Entry`: read-only entry rendering via `fill()`, with header actions; never emits input elements.
- Docs: see `docs/resources.md` (tabs, breadcrumbs), `docs/tables.md` (Card::table), `docs/pages.md` (Display).
- `refreshOn($channel, $events, $pollSeconds = 5, $private = false)` on `Container` and `Table`. Re-renders the Livewire component when a broadcast arrives via `window.Echo`; polls when Echo is absent. See `docs/live-updates.md`.
- `Streams\Ui\Widgets\LogTail`: append-only log widget with a line cap and auto-scroll pinning.
- Guarded Echo/Alpine bootstrap in `layouts/partials/assets.blade.php` (no-op without Echo).
- Added `RelationInput`: async searchable single or multiple entity picker with `stream()`, `query()`, `searchable()`, `multiple()`, `display()`, `limit()` and `createUsing()`. Ships one view, `builders/inputs/relation.blade.php`. See `docs/relation-input.md`.
- Added `Streams\Ui\Concerns\SearchesRelationInputs` page trait providing the search and create endpoints.