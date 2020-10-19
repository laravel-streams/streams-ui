<?php

namespace Streams\Ui\Table\Component\Filter\Workflows\Filters;

use Streams\Ui\Table\TableBuilder;
use Streams\Ui\Support\Normalizer;
use Streams\Ui\Table\Component\Filter\Type\FieldFilter;

/**
 * Class ExpandFilters
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ExpandFilters
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        $filters = $builder->filters;
        $stream = $builder->stream;

        foreach ($filters as $handle => &$filter) {

            if (!$stream) {
                continue;
            }

            if (isset($filter['field'])) {
                $filter['field'] = $stream->fields->{$filter['field']};
            }
        }

        $builder->filters = $filters;
    }
}
