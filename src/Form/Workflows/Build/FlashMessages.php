<?php

namespace Streams\Ui\Form\Workflows\Build;

use Streams\Ui\Form\FormBuilder;
use Streams\Core\Support\Facades\Messages;

/**
 * Class FlashMessages
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FlashMessages
{
    public function handle(FormBuilder $builder)
    {
        if (!$builder->validator) {
            return;
        }

        if (!$builder->validator->invalid()) {
            Messages::success('You win!');
        }

        if ($builder->validator->invalid()) {
            foreach ($builder->instance->errors->messages() as $errors) {
                Messages::error(implode("\n\r", $errors));
            }
        }
    }
}
