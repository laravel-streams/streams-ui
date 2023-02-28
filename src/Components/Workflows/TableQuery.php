<?php

namespace Streams\Ui\Components\Workflows;

use Streams\Ui\Components\Table;
use Streams\Core\Support\Workflow;
use Streams\Core\Criteria\Criteria;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TableQuery extends Workflow
{
    public array $steps = [
        'load_query' => self::class . '@loadQuery',
        'finish_query' => self::class . '@finishQuery',
    ];

    public function loadQuery(Table $component, Criteria $query): void
    {
        foreach ($component->query as $method => $parameters) {

            if (is_string($method)) {

                $query->{$method}(...$parameters);

                continue;
            }

            foreach ($query as $method => $parameters) {
                $query->{$method}(...$parameters);
            }
        }
    }

    public function finishQuery(Table $component, Criteria $query): void
    {
        $paginator = $query->paginate($component->pagination);

        $this->loadPagination($component, $paginator);

        $component->entries = $paginator->items();
    }

    protected function loadPagination(Table $component, Paginator $pagination)
    {
        $component->pagination = [
            'per_page' => $pagination->perPage(),
            'current_page' => $pagination->currentPage(),
            'from' => $pagination->firstItem(),
            'to' => $pagination->lastItem(),
        ];

        if ($pagination instanceof LengthAwarePaginator) {
            $component->pagination['total'] = $pagination->total();
            $component->pagination['last_page'] = $pagination->lastPage();
        }

        $component->pagination['links'] = function ($view = 'ui::laravel.default', array $data = []) use ($pagination) {
            return (string) $pagination->render($view, $data);
        };
    }
}
