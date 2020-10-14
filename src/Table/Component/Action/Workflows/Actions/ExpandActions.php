<?php

namespace Streams\Ui\Table\Component\Action\Workflows\Actions;

use Illuminate\Support\Str;
use Streams\Ui\Table\TableBuilder;
use Streams\Core\Stream\Stream;

/**
 * Class ExpandActions
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ExpandActions
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        $actions = $builder->actions;
        $stream = $builder->stream;

        foreach ($actions as $key => &$action) {

            if (!isset($action['text'])) {
                $this->guessText($stream, $action, $key);
            }
        }

        $builder->actions = $actions;
    }

    protected function guessText(Stream $stream, array &$action, $key)
    {
        if (\Illuminate\Support\Facades\App::make(\Illuminate\Translation\Translator::class)->has('ui::buttons.' . $action['handle'])) {
            
            $action['text'] = 'ui::buttons.' . $action['handle'];

            return;
        }

        $action['text'] = ucwords(Str::humanize($action['handle']));
    }
}
