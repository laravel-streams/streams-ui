<?php

namespace Streams\Ui\Table\Component\Action\Handler;

use Streams\Ui\Table\Table;
use Illuminate\Support\Facades\Redirect;
use Streams\Core\Support\Facades\Messages;

class Delete
{

    public function handle(Table $table, array $selected = [])
    {
        $count = 0;
        $total = count($selected);

        foreach ($selected as $id) {

            if (!$entry = $table->stream->repository()->find($id)) {
                continue;
            }

            if ($entry->delete()) {
                $count += 1;
            }
        }

        Messages::success(trans_choice('ui::messages.delete_success', $count, [
            'count' => $count . '/' . $total
        ]));

        $table->response = Redirect::back();
    }
}
