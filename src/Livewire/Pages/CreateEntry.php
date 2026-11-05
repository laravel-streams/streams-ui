<?php

namespace Streams\Ui\Livewire\Pages;

use Streams\Ui\Exceptions\Halt;
use Streams\Ui\Builders\Forms\Form;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Builders\Concerns\HasEntry;
use Streams\Ui\Notifications\Notification;
use Streams\Core\Entry\Contract\EntryInterface;

class CreateEntry extends PanelPage
{
    use HasEntry;

    public ?array $data = [];

    public ?string $previousUrl = null;

    protected static string $view = 'ui::livewire.pages.create-entry';

    public function form(Form $form): Form
    {
        return static::getResource()::form($form);
    }

    protected function getForms(): array
    {
        return [
            'default' => fn (): Form => $this->form(
                Form::make('default')
                    ->statePath('data')
                    ->stream(static::getResource()::getStream())
                    ->htmlAttributes(['wire:submit' => 'save'])
            ),
        ];
    }

    public function mount(): void
    {
        $this->fillForm();

        $this->previousUrl = url()->previous();
    }

    protected function fillForm(): void
    {
        $this->fire('beforeFill');

        $this->getForm()->fill($this->mutateFormDataBeforeFill([]));

        $this->fire('afterFill');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $data;
    }

    public function save(bool $shouldRedirect = true): void
    {
        try {
            $this->fire('beforeValidate');

            $data = $this->getForm()->getState();

            $this->fire('afterValidate');

            $data = $this->mutateFormDataBeforeCreate($data);

            $this->fire('beforeCreate');

            $entry = $this->handleEntryCreation($data);

            $this->entry($entry->getIdAttribute());

            $this->fire('afterCreate');
        } catch (Halt) {
            return;
        }

        $this->getCreatedNotification()?->push($this);

        if ($shouldRedirect) {
            $this->redirect($this->getRedirectUrl());
        }
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $data;
    }

    protected function handleEntryCreation(array $data): EntryInterface
    {
        return Streams::repository(static::getResource()::getStream())->create($data);
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()->title('Created')->success();
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
