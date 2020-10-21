<?php

namespace Streams\Ui\Form\Component\Button\Workflows\Buttons;

use Streams\Core\Stream\Stream;
use Streams\Ui\Form\FormBuilder;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Request;

/**
 * Class ExpandButtons
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ExpandButtons
{

    /**
     * Handle the step.
     *
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        $buttons = $builder->buttons;
        $stream = $builder->stream;

        foreach ($buttons as $key => &$button) {

            /**
             * Default guesser for cancel button.
             */
            if ($button['button'] == 'cancel' && !isset($button['attributes']['href'])) {
                $this->guessCancelHref($stream, $button, $key);
            }
        }

        $builder->buttons = $buttons;
    }

    protected function guessCancelHref(Stream $stream, array &$button, $key)
    {
        $button['attributes']['href'] = URL::route('ui::cp.index', ['stream' => $stream->handle]);
    }
}
