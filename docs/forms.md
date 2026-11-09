---
title: 'UI: Forms'
nav_title: Forms
description: 'Form::make(), Form::for($livewire), components, state, and validation.'
section: packages
package: ui
order: 100
tags: [ui, forms]
status: ready
---

Forms are built with `Streams\Ui\Builders\Forms\Form` — a Livewire-aware view builder.

## Factory methods

```php
$form = Form::make('post');              // named form
$form = Form::for($livewire);            // bound to Livewire component
Form::register($livewire);               // register default form on page
$form = Form::resolve();                 // resolve registered form
```

Resource pages call `Resource::form($form)` from `CreateEntry` and `EditEntry`.

## Schema API

Use `->components()` (not `schema()`):

```php
public static function form(Form $form): Form
{
    return $form->components([
        Field::make('title')
            ->input(TextInput::make('title')->required()),
        Field::make('body')
            ->input(TextareaInput::make('body')),
    ]);
}
```

## State

Forms use `$statePath` (default derived from form name). Livewire pages expose public `$data` array synchronized with form state through `InteractsWithForms`.

## Validation

Form builder uses `HandlesValidation` concern. Validation runs on save actions defined in CreateEntry/EditEntry page logic.

## Does not exist

- `UI::form()` Blade helper
- `->schema()` method on Form
- Automatic form generation from stream JSON without PHP

## Related

- [Form layouts](/docs/ui/form-layouts)
- [Inputs](/docs/ui/inputs)
- [Livewire integration](/docs/ui/livewire)
