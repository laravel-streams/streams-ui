<?php

namespace Streams\Ui\Forms\Concerns;

use Livewire\WithFileUploads;
use Streams\Ui\Forms\Form;

trait InteractsWithForms
{
    use WithFileUploads;

    protected Form $form;

    protected function makeForm(): Form
    {
        return Form::make($this);
    }

    public function bootInteractsWithForms(): void
    {
        $this->form = $this->form($this->makeForm($this));

        // $this->form = Action::configureUsing(
        //     Closure::fromCallable([$this, 'configureFormAction']),
        //     fn (): Form => BulkAction::configureUsing(
        //         Closure::fromCallable([$this, 'configureFormBulkAction']),
        //         fn (): Form => $this->form($this->makeForm()),
        //     ),
        // );

        // $this->cacheForm('toggleFormColumnForm', $this->getFormColumnToggleForm());

        // $this->cacheForm('formFiltersForm', $this->getFormFiltersForm());

        // if (! $this->shouldMountInteractsWithForm) {
        //     return;
        // }

        // if (! count($this->toggledFormColumns ?? [])) {
        //     $this->getFormColumnToggleForm()->fill(session()->get(
        //         $this->getFormColumnToggleFormStateSessionKey(),
        //         $this->getDefaultFormColumnToggleState()
        //     ));
        // }

        // $shouldPersistFiltersInSession = $this->getForm()->persistsFiltersInSession();
        // $filtersSessionKey = $this->getFormFiltersSessionKey();

        // if (! count($this->formFilters ?? [])) {
        //     $this->formFilters = null;
        // }

        // if (($this->formFilters === null) && $shouldPersistFiltersInSession && session()->has($filtersSessionKey)) {
        //     $this->formFilters = [
        //         ...($this->formFilters ?? []),
        //         ...(session()->get($filtersSessionKey) ?? []),
        //     ];
        // }

        // // https://github.com/filamentphp/filament/pull/7999
        // if ($this->formFilters) {
        //     $this->normalizeFormFilterValuesFromQueryString($this->formFilters);
        // }

        // $this->getFormFiltersForm()->fill($this->formFilters);

        // if ($shouldPersistFiltersInSession) {
        //     session()->put(
        //         $filtersSessionKey,
        //         $this->formFilters,
        //     );
        // }

        // if ($this->getForm()->isDefaultGroupSelecform()) {
        //     $this->formGrouping = $this->getForm()->getDefaultGroup()->getId();
        // }

        // $shouldPersistSearchInSession = $this->getForm()->persistsSearchInSession();
        // $searchSessionKey = $this->getFormSearchSessionKey();

        // if (blank($this->formSearch) && $shouldPersistSearchInSession && session()->has($searchSessionKey)) {
        //     $this->formSearch = session()->get($searchSessionKey);
        // }

        // $this->formSearch = strval($this->formSearch);

        // if ($shouldPersistSearchInSession) {
        //     session()->put(
        //         $searchSessionKey,
        //         $this->formSearch,
        //     );
        // }

        // $shouldPersistColumnSearchesInSession = $this->getForm()->persistsColumnSearchesInSession();
        // $columnSearchesSessionKey = $this->getFormColumnSearchesSessionKey();

        // if ((blank($this->formColumnSearches) || ($this->formColumnSearches === [])) && $shouldPersistColumnSearchesInSession && session()->has($columnSearchesSessionKey)) {
        //     $this->formColumnSearches = session()->get($columnSearchesSessionKey) ?? [];
        // }

        // $this->formColumnSearches = $this->castFormColumnSearches(
        //     $this->formColumnSearches ?? [],
        // );

        // if ($shouldPersistColumnSearchesInSession) {
        //     session()->put(
        //         $columnSearchesSessionKey,
        //         $this->formColumnSearches,
        //     );
        // }

        // $shouldPersistSortInSession = $this->getForm()->persistsSortInSession();
        // $sortSessionKey = $this->getFormSortSessionKey();

        // if (blank($this->formSortColumn) && $shouldPersistSortInSession && session()->has($sortSessionKey)) {
        //     $sort = session()->get($sortSessionKey);

        //     $this->formSortColumn = $sort['column'] ?? null;
        //     $this->formSortDirection = $sort['direction'] ?? null;
        // }

        // if ($shouldPersistSortInSession) {
        //     session()->put(
        //         $sortSessionKey,
        //         [
        //             'column' => $this->formSortColumn,
        //             'direction' => $this->formSortDirection,
        //         ],
        //     );
        // }

        // if ($this->getForm()->isPaginated()) {
        //     $this->formRecordsPerPage = $this->getDefaultFormRecordsPerPageSelectOption();
        // }
    }
}
