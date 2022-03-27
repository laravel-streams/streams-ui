<?php

namespace Streams\Ui\Components\Form\Action\Handler;

use Streams\Ui\Components\Form\Form;

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
