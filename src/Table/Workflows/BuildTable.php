<?php

namespace Anomaly\Streams\Ui\Table\Workflows;

use Anomaly\Streams\Platform\Support\Workflow;
use Anomaly\Streams\Ui\Support\Workflows\SetStream;
use Anomaly\Streams\Ui\Support\Workflows\LoadAssets;
use Anomaly\Streams\Ui\Support\Workflows\SetOptions;
use Anomaly\Streams\Ui\Support\Workflows\MakeComponent;
use Anomaly\Streams\Ui\Support\Workflows\SetRepository;
use Anomaly\Streams\Ui\Table\Workflows\Build\BuildRows;
use Anomaly\Streams\Ui\Support\Workflows\LoadBreadcrumb;
use Anomaly\Streams\Ui\Table\Workflows\Build\BuildViews;
use Anomaly\Streams\Ui\Table\Workflows\Build\BuildActions;
use Anomaly\Streams\Ui\Table\Workflows\Build\BuildButtons;
use Anomaly\Streams\Ui\Table\Workflows\Build\BuildColumns;
use Anomaly\Streams\Ui\Table\Workflows\Build\BuildFilters;
use Anomaly\Streams\Ui\Table\Workflows\Build\QueryEntries;
use Anomaly\Streams\Ui\Table\Workflows\Build\HandleRequest;
use Anomaly\Streams\Ui\Table\Workflows\Build\AuthorizeTable;

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
