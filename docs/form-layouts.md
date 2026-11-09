---
title: Form layouts
nav_title: Form layouts
description: Field, Fieldset, Container, Section, and Grid layout components.
section: packages
package: ui
order: 110
tags: [ui, form, layouts]
status: ready
---

Form layouts organize inputs in the admin UI. All layouts use `::make()` and `->components([...])`.

## Field

Wraps a single input:

```php
Field::make('title')
    ->label('Title')
    ->input(TextInput::make('title')),
```

Namespace: `Streams\Ui\Builders\Forms\Layouts\Field`

## Fieldset

Groups related fields:

```php
Fieldset::make('Meta')->components([
    Field::make('slug')->input(TextInput::make('slug')),
]),
```

## Container

Generic wrapper for nested components:

```php
Container::make()->components([/* ... */]),
```

## Section and Grid

Use container builders from `Streams\Ui\Builders\Containers`:

```php
Section::make('Details')->components([
    Grid::make()->columns(2)->components([
        Field::make('first_name')->input(TextInput::make('first_name')),
        Field::make('last_name')->input(TextInput::make('last_name')),
    ]),
]),
```

## Tabs

Tab navigation uses `Streams\Ui\Builders\Navigation\Tabs` for multi-section forms.

## Related

- [Forms](/docs/ui/forms)
- [Inputs](/docs/ui/inputs)
