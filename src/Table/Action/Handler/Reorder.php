<?php

namespace Streams\Ui\Table\Action\Handler;

use Illuminate\Http\Request;
use Streams\Core\Entry\EntryRepository;
use Streams\Ui\Table\TableBuilder;

/**
 * Class ReorderActionHandler
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Reorder
{

    /**
     * Save the order of the entries.
     *
     * @param TableBuilder $builder
     */
    public function handle(TableBuilder $builder)
    {
        $items = $builder->request('order', []);

        $repository = (new EntryRepository())->setModel($model = $builder->actionsTableModel());

        /* @var EloquentModel $entry */
        $repository->withoutEvents(
            function () use ($repository, $items) {
                foreach ($items as $k => $id) {

                    $repository
                        ->newQuery()
                        ->where('id', $id)
                        ->update([
                            'sort_order' => $k + 1,
                        ]);
                }
            }
        );

        $model->fireEvent('updatedMany');

        $count = count($items);

        $builder->fire('reordered', compact('count', 'builder', 'model'));

        $this->messages->success(trans('ui::message.reorder_success', compact('count')));
    }
}
