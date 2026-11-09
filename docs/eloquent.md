# Eloquent-backed resources

Tables, resources, forms and cards work with Eloquent models as well as Streams entries.

```php
class WidgetResource extends Resource
{
    protected static ?string $model = Widget::class;
}

$table->query(fn () => WidgetResource::scopedQuery());
```

- `Resource::scopedQuery()` returns an Eloquent Builder when `$model` is set, otherwise the stream's Criteria. Override it to scope records.
- `Resource::resolveModelRouteBinding($key)` finds a record by the model's route key; `resolveRecord($key)` picks models or entries automatically (used by the Edit/Create pages).
- Table filters, sorting, pagination, row URLs and bulk actions receive model instances. Selection uses the model key.
- `Form::entry($model)` / `Card` accept a Model; `getEntry()` returns its key.

Entry-based resources need no changes.
