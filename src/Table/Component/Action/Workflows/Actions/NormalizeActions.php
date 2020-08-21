<?php

namespace Anomaly\Streams\Ui\Table\Component\Action\Workflows\Actions;

use Anomaly\Streams\Ui\Table\TableBuilder;
use Anomaly\Streams\Ui\Support\Normalizer;

/**
 * Class NormalizeActions
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NormalizeActions
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        $actions = $builder->actions;

        if ($builder->instance->options->get('sortable')) {
            $actions = array_merge(['reorder'], $actions);
        }

        foreach ($actions as $handle => &$action) {

            /*
             * If the handle is numeric and the action is
             * a string then treat the string as both the
             * action and the handle. This is OK as long as
             * there are not multiple instances of this
             * input using the same action which is not likely.
             */
            if (is_numeric($handle) && is_string($action)) {
                $action = [
                    'handle' => $action,
                    'action' => $action,
                ];
            }

            /*
             * If the handle is NOT numeric and the action is a
             * string then use the handle as the handle and the
             * action as the action.
             */
            if (!is_numeric($handle) && is_string($action)) {
                $action = [
                    'handle' => $handle,
                    'action' => $action,
                ];
            }

            /*
             * If the handle is not numeric and the action is an
             * array without a handle then use the handle for
             * the handle for the action.
             */
            if (is_array($action) && !isset($action['handle']) && !is_numeric($handle)) {
                $action['handle'] = $handle;
            }

            /*
             * Make sure we have a action property.
             */
            if (is_array($action) && !isset($action['action'])) {
                $action['action'] = $action['handle'];
            }
        }

        $actions = Normalizer::attributes($actions);

        /**
         * Go back over and assume HREFs.
         * @todo reaction this - from guesser
         */
        foreach ($actions as $handle => &$action) {
            //
        }

        $builder->actions = $actions;
    }
}
