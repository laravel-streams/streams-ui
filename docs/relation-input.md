# RelationInput

Async searchable picker for related records.

```php
use Streams\Ui\Builders\Inputs\RelationInput;

RelationInput::make('person_id')
    ->stream('people')          // or ->query(fn (string $term) => [...])
    ->display('name')           // field name or fn ($record) => label
    ->searchable()
    ->multiple()                // submits an array of ids
    ->createUsing(fn (string $text) => Person::create(['name' => $text]));
```

The Livewire page must use `Streams\Ui\Concerns\SearchesRelationInputs`, which adds
`searchRelationInputOptions` and `createRelationInputOption`. Inputs register themselves on
render; override `relationInputs()` to return inputs by state path if they are not built during
the request. Results are capped by `limit()` (default 25); there is no pagination.
