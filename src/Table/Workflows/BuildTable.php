<?php

namespace Streams\Ui\Table\Workflows;

use Streams\Core\Support\Workflow;
use Streams\Ui\Support\Workflows\SetStream;
use Streams\Ui\Support\Workflows\LoadAssets;
use Streams\Ui\Support\Workflows\SetOptions;
use Streams\Ui\Support\Workflows\MakeComponent;
use Streams\Ui\Support\Workflows\SetRepository;
use Streams\Ui\Table\Workflows\Build\BuildRows;
use Streams\Ui\Table\Workflows\Build\ApplyView;
use Streams\Ui\Support\Workflows\LoadBreadcrumb;
use Streams\Ui\Table\Workflows\Build\BuildViews;
use Streams\Ui\Table\Workflows\Build\BuildActions;
use Streams\Ui\Table\Workflows\Build\BuildButtons;
use Streams\Ui\Table\Workflows\Build\BuildColumns;
use Streams\Ui\Table\Workflows\Build\BuildFilters;
use Streams\Ui\Table\Workflows\Build\QueryEntries;
use Streams\Ui\Table\Workflows\Build\HandleRequest;
use Streams\Ui\Table\Workflows\Build\AuthorizeTable;

/**
 * Class BuildTable
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildTable extends Workflow
{
    protected $steps = [
        MakeComponent::class,

        SetStream::class,
        SetOptions::class,
        
        LoadAssets::class,
        LoadBreadcrumb::class,        

        SetRepository::class,

        BuildViews::class,
        ApplyView::class,
        
        AuthorizeTable::class,

        BuildFilters::class,
        QueryEntries::class,

        BuildActions::class,
        HandleRequest::class,

        BuildButtons::class,
        BuildColumns::class,
        BuildRows::class,
    ];
}
