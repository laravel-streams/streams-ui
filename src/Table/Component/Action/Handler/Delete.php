<?php

namespace Streams\Ui\Table\Component\Action\Handler;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Streams\Ui\Table\TableBuilder;use Streams\Core\Support\Facades\Messages;
use Streams\Ui\Table\Table;

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
     * @param TableBuilder $table
     * @param array        $selected
     */
    public function handle(Table $table, array $selected = [])
    {
        $count = count($selected);

        foreach ($selected as $id) {

            if (!$entry = $table->stream->repository()->find($id)) {
                continue;
            }

            $entry->delete();
        }

        Messages::success(trans_choice('ui::messages.delete_success', $count, [
            'count' => $count
        ]));

        $table->response = Redirect::back();
    }
}
