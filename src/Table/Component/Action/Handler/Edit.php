<?php

namespace Anomaly\Streams\Ui\Table\Component\Action\Handler;

use Illuminate\Routing\Redirector;
use Anomaly\Streams\Ui\Table\TableBuilder;
use Anomaly\Streams\Ui\ControlPanel\Component\Section\SectionCollection;

/**
 * Class EditActionHandler
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Edit
{

    /**
     * Save the order of the entries.
     *
     * @param SectionCollection $sections
     * @param TableBuilder      $builder
     * @param array             $selected
     */
    public function handle(SectionCollection $sections, Redirector $redirector, TableBuilder $builder, array $selected)
    {
        $prefix = $builder->instance->options->get('prefix');

        $edit = array_shift($selected);
        $ids  = implode(',', $selected);

        if ($section = $sections->active()) {
            $builder->instance->response = $redirector->to(
                $section->getHref('edit/' . $edit . '?' . $prefix . 'edit_next=' . $ids)
            );
        }
    }
}
