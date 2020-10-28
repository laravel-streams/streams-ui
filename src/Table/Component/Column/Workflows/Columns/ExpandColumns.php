<?php

namespace Streams\Ui\Table\Component\Column\Workflows\Columns;

use Streams\Core\Stream\Stream;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Ui\Support\Normalizer;
use Streams\Ui\Table\TableBuilder;

/**
 * Class ExpandColumns
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ExpandColumns
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        $columns = $builder->columns;
        $stream = $builder->stream;

        foreach ($columns as $key => &$column) {

            if (!isset($column['field'])) {
                $this->guessField($stream, $column, $key);
            }

            if (isset($column['field'])) {
                $this->expandColumn($builder, $stream, $column);
            }

            if (!isset($column['heading']) && $column['value'] == 'id') {
                $column['heading'] = 'ID';
                $column['sortable'] = true;
            }
        }

        $builder->columns = $columns;
    }

    protected function guessField(Stream $stream, array &$column, $key)
    {
        if (!is_numeric($key) && $field = $stream->fields->get($key)) {
            
            $column['field'] = $field->handle;

            return;
        }

        if (isset($column['value']) && $field = $stream->fields->get($column['value'])) {
            
            $column['field'] = $field->handle;
            
            return;
        }
    }

    protected function expandColumn(TableBuilder $table, Stream $stream, array &$column)
    {
        $field = $stream->fields->get($column['field']);

        if (!isset($column['sortable'])) {
            $column['sortable'] = true; // @todo can field be sortable?
        }

        if (!isset($column['heading'])) {
            $column['heading'] = $field->name ?: ucwords(Str::humanize($field->handle));
        }

        if ($table->request('order_by') == $column['field']) {
            $column['direction'] = $table->request('sort');
        }
    }
}
