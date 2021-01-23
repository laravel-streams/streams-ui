<?php

namespace Streams\Ui\Form\Component\Action\Handler;

use Streams\Ui\Form\Form;
use Streams\Core\Support\Facades\Messages;

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

        $result = $form->stream->repository()->save($entry);

        $form->entry = $form->entry = $entry;

        Messages::success(trans('ui::messages.save_success'));
    }
}
