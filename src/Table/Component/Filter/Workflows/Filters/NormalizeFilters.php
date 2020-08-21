<?php

namespace Anomaly\Streams\Ui\Table\Component\Filter\Workflows\Filters;

use Anomaly\Streams\Ui\Table\TableBuilder;
use Anomaly\Streams\Ui\Support\Normalizer;
use Anomaly\Streams\Ui\Table\Component\Filter\Type\FieldFilter;

/**
 * Class NormalizeFilters
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NormalizeFilters
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        $filters = $builder->filters;

        if ($builder->instance->options->get('sortable')) {
            $filters = array_merge(['reorder'], $filters);
        }

        foreach ($filters as $handle => &$filter) {

            /*
             * If the handle is numeric and the filter is
             * a string then treat the string as both the
             * filter and the handle. This is OK as long as
             * there are not multiple instances of this
             * input using the same filter which is not likely.
             */
            if (is_numeric($handle) && is_string($filter)) {
                $filter = [
                    'handle' => $filter,
                    'filter' => FieldFilter::class,
                ];
            }

            /*
             * If the handle is NOT numeric and the filter is a
             * string then use the handle as the handle and the
             * filter as the filter.
             */
            if (!is_numeric($handle) && is_string($filter)) {
                $filter = [
                    'handle' => $handle,
                    'filter' => $filter,
                ];
            }

            /*
             * If the handle is not numeric and the filter is an
             * array without a handle then use the handle for
             * the handle for the filter.
             */
            if (is_array($filter) && !isset($filter['handle']) && !is_numeric($handle)) {
                $filter['handle'] = $handle;
            }

            /*
             * Make sure we have a filter property.
             */
            if (is_array($filter) && !isset($filter['filter'])) {
                $filter['filter'] = $filter['handle'];
            }
        }

        $filters = Normalizer::attributes($filters);

        /**
         * Go back over and assume HREFs.
         * @todo refilter this - from guesser
         */
        foreach ($filters as $handle => &$filter) {
            //
        }

        $builder->filters = $filters;
    }
}
