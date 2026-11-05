<?php

namespace Streams\Ui\Tests\Fixtures\Todos;

use Streams\Ui\Resources\Resource;
use Streams\Ui\Builders\Forms\Form;
use Streams\Ui\Builders\Tables\Table;
use Streams\Ui\Builders\Inputs\TextInput;
use Streams\Ui\Builders\Inputs\ToggleInput;
use Streams\Ui\Builders\Forms\Layouts\Field;
use Streams\Ui\Builders\Tables\Columns\TextColumn;

class TodoResource extends Resource
{
    protected static ?string $stream = 'todos';

    protected static ?string $slug = 'todos';

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTodos::route('/'),
            'create' => Pages\CreateTodo::route('/create'),
            'edit' => Pages\EditTodo::route('/{entry}/edit'),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form->components([
            Field::make('Description')->components([
                TextInput::make('description')->required()->maxLength(255),
            ]),
            Field::make('Completed')->components([
                ToggleInput::make('completed'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('description'),
        ]);
    }
}
