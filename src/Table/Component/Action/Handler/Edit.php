<?php

namespace Streams\Ui\Table\Component\Action\Handler;

use Streams\Ui\Table\Table;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;

class Edit
{

    public function handle(Table $table, array $selected = [])
    {
        $prefix = $table->options->get('prefix');

        $edit = array_shift($selected);
        $ids  = implode(',', $selected);

        $base = URL::previous(URL::current());

        $query = '?' . $prefix . 'edit_next=' . $ids;

        $table->response = Redirect::to($base . '/' . $edit . '/edit/' . $query);
    }
}
