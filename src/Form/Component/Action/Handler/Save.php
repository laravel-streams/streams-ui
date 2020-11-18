<?php

namespace Streams\Ui\Form\Component\Action\Handler;

use Streams\Ui\Form\Form;

/**
 * Class Save
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Save
{
    public function handle(Form $form)
    {
        if ($form->errors->isNotEmpty()) {
            return;
        }

        $entry = $form->entry ?: $form->stream->repository()->newInstance();

        foreach ($form->values as $field => $value) {
            $entry->{$field} = $value;
        }

        $form->stream->repository()->save($entry);

        $form->entry = $form->entry = $entry;
    }
}
