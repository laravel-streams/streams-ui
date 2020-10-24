<?php

namespace Streams\Ui\Table\Component\Action\Handler;

use Streams\Ui\Table\TableBuilder;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Streams\Ui\ControlPanel\Component\Section\SectionCollection;

class Edit
{

    /**
     * Save the order of the entries.
     *
     * @param SectionCollection $sections
     * @param TableBuilder      $builder
     * @param array             $selected
     */
    public function handle(TableBuilder $builder, array $selected = [])
    {
        $prefix = $builder->instance->options->get('prefix');

        $edit = array_shift($selected);
        $ids  = implode(',', $selected);

        $builder->response = Redirect::to(
            URL::to(URL::current() . '/update/' . $edit . '?' . $prefix . 'edit_next=' . $ids)
        );
    }
}
