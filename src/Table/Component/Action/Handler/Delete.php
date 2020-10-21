<?php

namespace Streams\Ui\Table\Component\Action\Handler;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Streams\Ui\Table\TableBuilder;use Streams\Core\Support\Facades\Messages;

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

        $builder->response = Redirect::back();
    }
}
