<?php

namespace Streams\Ui\Pages;

use Streams\Ui\Forms\Form;
use Streams\Ui\Forms\Concerns\HasForm;

class EditEntry extends Page
{
    use HasForm;

    protected static string $view = 'ui::pages.edit-entry';

    public function form(Form $table): Form
    {
        return static::getResource()::form($table);
    }
}
