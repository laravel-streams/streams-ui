---
title: Inputs
nav_title: Inputs
description: 'Input classes in Streams\\Ui\\Builders\\Inputs.'
section: packages
package: ui
order: 120
tags: [ui, inputs]
status: ready
---

Inputs define form controls. All extend `Streams\Ui\Builders\Inputs\Input` and use `InputClass::make('field_handle')`.

## Available inputs

| Class | Purpose |
|-------|---------|
| `TextInput` | Text, email, url, number (via type) |
| `TextareaInput` | Multi-line text |
| `SelectInput` | Single select |
| `CheckboxInput` | Checkbox |
| `RadioInput` | Radio group |
| `ToggleInput` | Boolean toggle |
| `DateInput` | Date picker |
| `DatetimeInput` | Datetime picker |
| `TimeInput` | Time picker |
| `FileInput` | File upload field |
| `ColorInput` | Color picker |
| `TagsInput` | Tag list |
| `MarkdownInput` | Markdown editor |
| `EditorInput` | Rich text editor |

## Example

```php
TextInput::make('title')
    ->label('Title')
    ->required()
    ->maxLength(255),

SelectInput::make('status')
    ->options(['draft' => 'Draft', 'published' => 'Published']),
```

## Usage in forms

Wrap inputs in `Field::make()` inside form `components()`:

```php
Field::make('email')->input(
    TextInput::make('email')->type('email')
),
```

## Related

- [Forms](/docs/ui/forms)
- [Form layouts](/docs/ui/form-layouts)
