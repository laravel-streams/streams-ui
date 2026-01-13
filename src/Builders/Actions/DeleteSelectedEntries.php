<?php

namespace Streams\Ui\Builders\Actions;

use Streams\Ui\Notifications\Notification;
use Streams\Ui\Builders\Concerns as Common;
use Streams\Ui\Builders\Tables\BulkActions\BulkAction;

class DeleteSelectedEntries extends BulkAction
{
    use Common\HasStream;

    protected function setUp(): void
    {
        $this
            ->label('Delete Selected')
            ->color('danger')
            ->action(function (array $selectedEntries): void {

                $entries = $this->getStreamInstance()->entries();

                foreach ($selectedEntries as $id) {
                    $entries->find($id)?->delete();
                }

                Notification::make()
                    ->title('Selected entries have been deleted.')
                    ->duration(5)
                    ->success()
                    ->send();
            })
            ->mergeHtmlAttributes(function () {
                return [
                    'wire:click' => 'mountTableBulkAction(\''.$this->getName().'\')',
                ];
            });
    }
}
