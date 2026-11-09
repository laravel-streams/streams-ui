# Default filters and modal forms

## Table default filters

```php
Table::make()
    ->filters([SelectFilter::make('status')->options([...])])
    ->defaultFilters(['status' => 'active']);

// or per filter
SelectFilter::make('status')->default('active');
```

The value is applied on first load. Resetting filters clears it (back to empty). `Table::defaultFilters` takes precedence over `Filter::default`.

## Modal forms

```php
MountableAction::make('create')
    ->modalForm(Form::make('create-form')->components([...]))
    ->action(fn () => ...);
```

Submitting the form (Enter or the button) calls `Form::handle()`, which validates and then runs the mounted action, which closes the modal. Override `handle()` on a form subclass to customise.
