<?php

namespace Streams\Ui\Traits;

use Streams\Core\Criteria\Criteria;
use Illuminate\Contracts\Pagination\Paginator;

trait CanBePaginated
{
    public int | string $perPage = 25;

    protected bool | \Closure $paginated = true;

    protected array | \Closure | null $paginationOptions = null;

    public function perPage($perPage): self
    {
        $this->perPage = $perPage;

        return $this;
    }

    public function paginated(bool | array | \Closure $condition = true): static
    {
        if (is_array($condition)) {

            $this->paginationOptions($condition);

            $condition = true;
        }

        $this->isPaginated = $condition;

        return $this;
    }

    public function paginationOptions(array | \Closure | null $options): static
    {
        $this->paginationOptions = $options;

        return $this;
    }

    public function isPaginated(): bool
    {
        return $this->evaluate($this->paginated); // && (! $this->isGroupsOnly())
    }

    protected function paginateQuery(Criteria $query): Paginator
    {
        //$perPage = $this->getPerPage();
        $perPage = $this->getLiveWire()->getTableRecordsPerPage();
        $pageName = $this->getTablePageName();

        /** @var LengthAwarePaginator $records */
        $records = $query->paginate([
            'total' => $total = $query->count(),
            'page_name' => $pageName,
            'page' => $this->getLivewire()->paginators[$pageName] ?? 1,
            'per_page' => $perPage === 'all' ? $total : $perPage,
        ]);

        return $records->onEachSide(0);
    }

    public function getTablePageName(): string
    {
        return $this->getLivewire()->getQueryStringPropertyName('page');
    }

    public function getPaginationOptions(): array
    {
        return $this->evaluate($this->paginationOptions) ?? [
            5,
            10,
            25,
            50,
            100,
            'all',
        ];
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }
}
