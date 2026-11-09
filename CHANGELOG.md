# Changelog

## Unreleased

- `Resource::$tabs`, `getTabs()`, `getBreadcrumbs()`: declarative tabs with route-derived active state and a breadcrumb chain.
- `Card::table($table, $rowActions)`: host a Table in a Card; row `MountableAction`s mount with the entry, no `UiActions::register` call.
- `Display` and `Display\Entry`: read-only entry rendering via `fill()`, with header actions; never emits input elements.
- Docs: see `docs/resources.md` (tabs, breadcrumbs), `docs/tables.md` (Card::table), `docs/pages.md` (Display).
