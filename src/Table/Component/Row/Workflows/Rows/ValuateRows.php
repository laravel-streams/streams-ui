<?php

namespace Anomaly\Streams\Ui\Table\Component\Row\Workflows\Rows;

use Illuminate\Support\Arr;
use Anomaly\Streams\Ui\Support\Value;
use Anomaly\Streams\Ui\Table\TableBuilder;
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

            $row->columns = new Collection();
            $row->buttons = new Collection();

            foreach ($builder->instance->columns as $key => $column) {

                $clone = clone ($column);

                $clone->value = Value::make($column->getAttributes(), $row->entry);

                $row->columns->put($key, $clone);
            }

            foreach ($builder->instance->buttons as $button) {

                $clone = clone ($button);

                $clone->fill(Arr::parse($button->getAttributes(), [
                    'entry' => $row->entry,
                ]));

                $row->buttons->put($key, $clone);
            }
        });
    }
}
