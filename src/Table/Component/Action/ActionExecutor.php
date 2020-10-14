<?php

namespace Streams\Ui\Table\Component\Action;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Application;
use Streams\Ui\Table\TableBuilder;
use Streams\Core\Message\Facades\Messages;
use Streams\Core\Addon\Module\ModuleCollection;
use Streams\Ui\Table\Component\Action\Action;

/**
 * Class ActionExecutor
 *
 * @link          http://anomaly.is/streams-plattable
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ActionExecutor
{

    /**
     * The module collection.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * The application.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new ActionExecutor instance.
     *
     * @param Application      $application
     * @param ModuleCollection $modules
     */
    public function __construct(
        Application $application,
        ModuleCollection $modules
    ) {
        $this->modules     = $modules;
        $this->application = $application;
    }

    /**
     * Execute an action.
     *
     * @param  TableBuilder $builder
     * @param  Action $action
     * @throws \Exception
     */
    public function execute(TableBuilder $builder, Action $action)
    {
        /*
         * Authorize the action.
         */
        if ($action->policy && !Gate::any((array) $action->policy)) {

            Messages::error('ui::message.403');

            return;
        }

        /*
         * If no rows are selected then 
         * we have nothing to do. Heads up!
         */
        if (!$selected = $builder->request('id', [])) {

            messages('warning', trans('ui::message.no_rows_selected'));

            return;
        }

        App::call($action->handler, compact('builder', 'selected'), 'handle');

        return;
    }
}
