<?php

namespace Streams\Ui\Table\Component\Row\Workflows\Rows;

use Illuminate\Support\Arr;
use Streams\Ui\Support\Value;
use Streams\Ui\Table\TableBuilder;
use Illuminate\Support\Collection;

/**
 * Class ValuateRows
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ValuateRows
{

    /**
     * Handle the step.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        $builder->instance->rows->each(function ($row) use ($builder) {

            $row->columns = [];
            $row->buttons = [];

            foreach ($builder->instance->columns as $key => $column) {

                $clone = clone ($column);

                $clone->value = Value::make($column->getPrototypeAttributes(), $row->entry);

                $row->columns->put($key, $clone);
            }

            foreach ($builder->instance->buttons as $button) {

                $clone = clone ($button);

                $clone->setPrototypeAttributes(Arr::parse($button->getPrototypeAttributes(), [
                    'entry' => $row->entry,
                    'stream' => $builder->stream,
                ]));

                $row->buttons->put($clone->handle, $clone);
            }
        });
    }
}
