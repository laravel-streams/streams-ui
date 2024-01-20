<?php

namespace Streams\Ui\Pages;

use Streams\Ui\Forms\Form;
use Streams\Core\Entry\Entry;
use Streams\Ui\Traits\HasEntry;
use Streams\Ui\Pages\PanelPage;
use Streams\Ui\Components\Forms\InteractsWithForms;

class CreateEntry extends PanelPage
{
    use HasEntry;
    use InteractsWithForms;

    public ?array $data = [];

    public ?string $previousUrl = null;

    protected static string $view = 'ui::pages.create-entry';

    public function form(Form $table): Form
    {
        return static::getResource()::form($table);
    }
    
    public function mount(): void
    {
        //$this->entry = $this->resolveEntry($entry);

        //$this->authorizeAccess();

        //$this->fillForm();

        $this->previousUrl = url()->previous();
    }

    protected function resolveEntry(int | string $key): Entry
    {
        $entry = static::getResource()::resolveEntryRouteBinding($key);

        if ($entry === null) {
            throw (new \Exception("Entry [$key] not found"));
        }

        return $entry;
    }

    protected function authorizeAccess(): void
    {
        static::authorizeResourceAccess();

        abort_unless(static::getResource()::canEdit($this->getRecord()), 403);
    }

    protected function fillForm(): void
    {
        $data = $this->getEntryInstance()->toArray();

        $this->fillFormWithDataAndCallHooks($data);
    }

    protected function fillFormWithDataAndCallHooks(array $data): void
    {
        $this->fire('beforeFill');

        $data = $this->mutateFormDataBeforeFill($data);

        $this->form->fill($data);

        $this->fire('afterFill');
    }

    protected function refreshFormData(array $attributes): void
    {
        $this->data = [
            ...$this->data,
            ...$this->getEntryInstance()->only($attributes),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $data;
    }

    public function save(bool $shouldRedirect = true): void
    {
        $this->authorizeAccess();

        try {
            /** @internal Read the DocBlock above the following method. */
            $this->validateFormAndUpdateRecordAndCallHooks();
        } catch (Halt $exception) {
            return;
        }

        /** @internal Read the DocBlock above the following method. */
        $this->sendSavedNotificationAndRedirect(shouldRedirect: $shouldRedirect);
    }

    /**
     * @internal Never override or call this method. If you completely override `save()`, copy the contents of this method into your override.
     */
    protected function validateFormAndUpdateRecordAndCallHooks(): void
    {
        $this->callHook('beforeValidate');

        $data = $this->form->getState();

        $this->callHook('afterValidate');

        $data = $this->mutateFormDataBeforeSave($data);

        $this->callHook('beforeSave');

        $this->handleRecordUpdate($this->getRecord(), $data);

        $this->callHook('afterSave');
    }

    /**
     * @internal Never override or call this method. If you completely override `save()`, copy the contents of this method into your override.
     */
    protected function sendSavedNotificationAndRedirect(bool $shouldRedirect = true): void
    {
        $this->getSavedNotification()?->send();

        if ($shouldRedirect && ($redirectUrl = $this->getRedirectUrl())) {
            if (FilamentView::hasSpaMode()) {
                $this->redirect($redirectUrl, navigate: is_app_url($redirectUrl));
            } else {
                $this->redirect($redirectUrl);
            }
        }
    }

    protected function getSavedNotification(): ?Notification
    {
        $title = $this->getSavedNotificationTitle();

        if (blank($title)) {
            return null;
        }

        return Notification::make()
            ->success()
            ->title($this->getSavedNotificationTitle());
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return $this->getSavedNotificationMessage() ?? __('filament-panels::resources/pages/edit-record.notifications.saved.title');
    }

    /**
     * @deprecated Use `getSavedNotificationTitle()` instead.
     */
    protected function getSavedNotificationMessage(): ?string
    {
        return null;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        return $record;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $data;
    }
}
