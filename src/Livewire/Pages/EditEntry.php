<?php

namespace Streams\Ui\Livewire\Pages;

use Streams\Ui\Exceptions\Halt;
use Streams\Ui\Builders\Forms\Form;
use Streams\Ui\Builders\Concerns\HasEntry;
use Streams\Ui\Notifications\Notification;
use Streams\Core\Entry\Contract\EntryInterface;

class EditEntry extends PanelPage
{
    use HasEntry;

    public ?array $data = [];

    public ?string $previousUrl = null;

    protected static string $view = 'ui::livewire.pages.edit-entry';

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

    public function mount(int|string $entry): void
    {
        $this->entry($this->resolveEntry($entry)->getIdAttribute());

        $this->fillForm();

        $this->previousUrl = url()->previous();
    }

    /**
     * Only the key is kept on the component so Livewire can round-trip it.
     */
    public function getEntryInstance(): EntryInterface
    {
        return $this->resolveEntry($this->getEntry());
    }

    protected function resolveEntry(int|string $key): EntryInterface
    {
        $entry = static::getResource()::resolveEntryRouteBinding($key);

        if ($entry === null) {
            abort(404, "Entry [{$key}] not found.");
        }

        return $entry;
    }

    protected function fillForm(): void
    {
        $this->fire('beforeFill');

        $data = $this->mutateFormDataBeforeFill($this->getEntryInstance()->toArray());

        $this->getForm()->fill($data);

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

            $data = $this->mutateFormDataBeforeSave($data);

            $this->fire('beforeSave');

            $this->handleEntryUpdate($this->getEntryInstance(), $data);

            $this->fire('afterSave');
        } catch (Halt) {
            return;
        }

        $this->getSavedNotification()?->push($this);

        if ($shouldRedirect) {
            $this->redirect($this->getRedirectUrl());
        }
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $data;
    }

    protected function handleEntryUpdate(EntryInterface $entry, array $data): EntryInterface
    {
        foreach ($data as $key => $value) {
            $entry->{$key} = $value;
        }

        $entry->save();

        return $entry;
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()->title('Saved')->success();
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?: static::getResource()::getUrl('index');
    }
}
