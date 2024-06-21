<?php 

namespace Streams\Ui\Components\Tables\Concerns;

use Streams\Core\Criteria\Criteria;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Database\Query\Builder;

trait CanPaginateEntries
{
    public $tableRecordsPerPage = null;

    protected int | string | null $defaultTableRecordsPerPageSelectOption = null;

    public function updatedTableRecordsPerPage(): void
    {
        session()->put([
            $this->getTablePerPageSessionKey() => $this->getTableRecordsPerPage(),
        ]);

        $this->resetPage();
    }

    protected function paginateQuery(Criteria | Builder $query): Paginator
    {
        $perPage = $this->getTableRecordsPerPage();

        /** @var LengthAwarePaginator $records */
        $records = $query->paginate(
            $perPage === 'all' ? $query->count() : $perPage,
            ['*'],
            $this->getTablePaginationPageName(),
            $this->paginators[$this->getTablePaginationPageName()] ?? 1
        );

        return $records->onEachSide(0);
    }

    public function getTableRecordsPerPage(): int | string | null
    {
        return $this->tableRecordsPerPage ?: $this->table->getPerPage();
    }

    public function getTablePage(): int
    {
        return $this->getPage($this->getTablePaginationPageName());
    }

    public function getDefaultTableRecordsPerPageSelectOption(): int | string
    {
        $option = session()->get(
            $this->getTablePerPageSessionKey(),
            $this->defaultTableRecordsPerPageSelectOption ?? $this->getTable()->getDefaultPaginationPageOption(),
        );

        $pageOptions = $this->getTable()->getPaginationPageOptions();

        if (in_array($option, $pageOptions)) {
            return $option;
        }

        session()->remove($this->getTablePerPageSessionKey());

        return $pageOptions[0];
    }

    public function getTablePaginationPageName(): string
    {
        return $this->getQueryStringPropertyName('page');
    }

    public function getTablePerPageSessionKey(): string
    {
        $table = class_basename($this::class);

        return "tables.{$table}_per_page";
    }

    /**
     * @deprecated Override the `table()` method to configure the table.
     *
     * @return array<int | string> | null
     */
    protected function getTableRecordsPerPageSelectOptions(): ?array
    {
        return null;
    }

    /**
     * @deprecated Override the `table()` method to configure the table.
     */
    protected function isTablePaginationEnabled(): bool
    {
        return true;
    }
}
