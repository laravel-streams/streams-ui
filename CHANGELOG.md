# Changelog

## Unreleased

- `Resource::$tabs`, `getTabs()`, `getBreadcrumbs()`: declarative tabs with route-derived active state and a breadcrumb chain.
- `Card::table($table, $rowActions)`: host a Table in a Card; row `MountableAction`s mount with the entry, no `UiActions::register` call.
- `Display` and `Display\Entry`: read-only entry rendering via `fill()`, with header actions; never emits input elements.
- Docs: see `docs/resources.md` (tabs, breadcrumbs), `docs/tables.md` (Card::table), `docs/pages.md` (Display).
- Added `RelationInput`: async searchable single or multiple entity picker with `stream()`, `query()`, `searchable()`, `multiple()`, `display()`, `limit()` and `createUsing()`. Ships one view, `builders/inputs/relation.blade.php`. See `docs/relation-input.md`.
- Added `Streams\Ui\Concerns\SearchesRelationInputs` page trait providing the search and create endpoints.
