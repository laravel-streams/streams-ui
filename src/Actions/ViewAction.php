<?php

namespace Streams\Ui\Actions;

use Streams\Core\Entry\Entry;
use Streams\Ui\Tables\Table;
use Streams\Ui\Traits as Common;

class ViewAction extends MountableAction
{
    // protected string $viewIdentifier = 'view';

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('filament-actions::view.single.label'));

        // $this->modalHeading(fn (): string => __('filament-actions::view.single.modal.heading', ['label' => $this->getEntryTitle()]));

        // $this->modalSubmitAction(false);
        // $this->modalCancelAction(fn (Action $action) => $action->label(__('filament-actions::view.single.modal.actions.close.label')));

        $this->color('red');

        $this->icon('heroicon-m-eye');

        // $this->disabledForm();

        // $this->fillForm(function (Entry $entry, Table $table): array {
            // if ($translatableContentDriver = $table->makeTranslatableContentDriver()) {
            //     $data = $translatableContentDriver->getEntryAttributesToArray($entry);
            // } else {
                // $data = $entry->attributesToArray();
            // }

            // if ($this->mutateEntryDataUsing) {
            //     $data = $this->evaluate($this->mutateEntryDataUsing, ['data' => $data]);
            // }

        //     return $data;
        // });

        $this->action(static function (): void {
        });
    }
}
