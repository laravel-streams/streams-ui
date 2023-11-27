<?php

namespace Streams\Ui\Pages;

use Streams\Ui\Forms\Form;
use Streams\Ui\Forms\Concerns\InteractsWithForms;

class EditEntry extends Page
{
    use InteractsWithForms;

    protected static string $view = 'ui::pages.edit-entry';

    public function form(Form $table): Form
    {
        return static::getResource()::form($table);
    }
}
