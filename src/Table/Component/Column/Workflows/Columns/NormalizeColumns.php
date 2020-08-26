<?php

namespace Anomaly\Streams\Ui\Table\Component\Column\Workflows\Columns;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Anomaly\Streams\Ui\Support\Normalizer;
use Anomaly\Streams\Ui\Table\TableBuilder;

/**
 * Class NormalizeColumns
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NormalizeColumns
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        $columns = $builder->columns;

        foreach ($columns as $key => &$column) {

            /*
             * If the key is numeric then discard it.
             */
            if (is_string($column) && is_numeric($key)) {
                $column = [
                    'value'   => $column,
                ];
            }

            /*
             * If the key is non-numerical then
             * use it as the field and use the
             * column as the column if it's a class.
             */
            if (is_string($column) && !is_numeric($key)) {
                $column = [
                    'field' => $key,
                    'value'  => $column,
                ];
            }
        }

        $columns = Normalizer::attributes($columns);

        /**
         * Go back over and assume HREFs.
         * @todo recolumn this - from guesser
         */
        foreach ($columns as $key => &$column) {
            //dd($column);
        }

        $builder->columns = $columns;
    }
}
