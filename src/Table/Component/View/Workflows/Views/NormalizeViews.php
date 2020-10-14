<?php

namespace Streams\Ui\Table\Component\View\Workflows\Views;

use Illuminate\Support\Arr;
use Streams\Ui\Support\Normalizer;
use Streams\Ui\Table\TableBuilder;

/**
 * Class NormalizeViews
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NormalizeViews
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        $views = $builder->views;

        foreach ($views as $handle => &$view) {

            /*
             * If the handle is numeric and the view is
             * a string then treat the string as both the
             * view and the handle. This is OK as long as
             * there are not multiple instances of this
             * input using the same view which is not likely.
             */
            if (is_numeric($handle) && is_string($view)) {
                $view = [
                    'handle' => $view,
                    'view' => $view,
                ];
            }

            /*
             * If the handle is NOT numeric and the view is a
             * string then use the handle as the handle and the
             * view as the view.
             */
            if (!is_numeric($handle) && is_string($view)) {
                $view = [
                    'handle' => $handle,
                    'view' => $view,
                ];
            }

            /*
             * If the handle is not numeric and the view is an
             * array without a handle then use the handle for
             * the handle for the view.
             */
            if (is_array($view) && !isset($view['handle']) && !is_numeric($handle)) {
                $view['handle'] = $handle;
            }

            /*
             * Make sure we have a view property.
             */
            if (is_array($view) && !isset($view['view'])) {
                $view['view'] = $view['handle'];
            }
        }

        $views = Normalizer::attributes($views);

        /**
         * Go back over and assume HREFs.
         * @todo review this - from guesser
         */
        foreach ($views as $handle => &$view) {

            // Only automate it if not set.
            if (!isset($view['attributes']['href'])) {
                $view['attributes']['href'] = url(
                    request()->path() . '?' . Arr::get($view, 'prefix') . 'view=' . $view['handle']
                );
            }
        }

        $builder->views = $views;
    }
}
