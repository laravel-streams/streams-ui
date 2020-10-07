<?php

namespace Anomaly\Streams\Ui\Table\Component\Action\Handler;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Support\Facades\Messages;
use Anomaly\Streams\Ui\Table\TableBuilder;

/**
 * Class DeleteActionHandler
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Delete
{

    /**
     * Delete the selected entries.
     *
     * @param TableBuilder $builder
     * @param array        $selected
     */
    public function handle(TableBuilder $builder, array $selected = [])
    {
        $count = count($selected);

        foreach ($selected as $id) {

            if (!$entry = $builder->repository->find($id)) {
                continue;
            }

            $entry->delete();
        }

        Messages::success(trans_choice('ui::messages.delete_success', $count, [
            'count' => $count
        ]));
    }
}
