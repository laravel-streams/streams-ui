# Changelog

## Unreleased

### Added

- `Table::defaultFilters(array $values)` and `Filter::default($value)` seed filter values on first load. Resetting filters clears them.
- `MountableAction::modalForm(Form|array|Closure $form)` attaches a form to the action modal. Submitting it (Enter or button) validates the form, runs the mounted action and closes the modal.
- `Form::handle()` default implementation (validate, then `callMountedAction`) and `Form::submitsMountedAction()`. Existing `handle()` overrides keep working.

### Also added

- Added `RelationInput`: async searchable single or multiple entity picker with `stream()`, `query()`, `searchable()`, `multiple()`, `display()`, `limit()` and `createUsing()`. Ships one view, `builders/inputs/relation.blade.php`. See `docs/relation-input.md`.
- Added `Streams\Ui\Concerns\SearchesRelationInputs` page trait providing the search and create endpoints.
