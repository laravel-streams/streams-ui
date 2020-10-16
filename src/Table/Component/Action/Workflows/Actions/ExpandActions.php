<?php

namespace Streams\Ui\Table\Component\Action\Workflows\Actions;

use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Streams\Ui\Table\TableBuilder;
use Illuminate\Support\Facades\App;

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

            /**
             * If no text is set then
             * guess it from the handle.
             */
            if (!isset($action['text'])) {
                $this->guessText($stream, $action, $key);
            }

            /**
             * If no value is set then
             * guess it from the handle.
             */
            if (!isset($action['value'])) {
                $action['value'] = $action['handle'];
            }
        }

        $builder->actions = $actions;
    }

    protected function guessText(Stream $stream, array &$action, $key)
    {
        if (App::make('translator')->has('ui::buttons.' . $action['handle'])) {
            
            $action['text'] = 'ui::buttons.' . $action['handle'];

            return;
        }

        $action['text'] = ucwords(Str::humanize($action['handle']));
    }
}
