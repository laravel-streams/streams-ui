<?php

namespace Streams\Ui\Http\Controller;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\ControlPanel\ControlPanelBuilder;
use Streams\Core\Http\Controller\StreamsController;

/**
 * Class UiController
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class UiController extends StreamsController
{

    protected $steps = [
        'resolve_section',
        'resolve_stream',
        'resolve_entry',
        'resolve_view',
        'resolve_redirect',
        'resolve_response',
    ];

    /**
     * Go somewhere useful.
     * 
     * @return RedirectResponse
     */
    public function index(ControlPanelBuilder $builder)
    {
        $navigation = $builder->makeNavigation();

        if (!$home = $navigation->first()) {
            abort(404);
        }

        return Redirect::to($home->url());
    }

    /**
     * Handle the request.
     * 
     * @return Response
     */
    public function handle()
    {
        return parent::handle();
    }

    public function resolveSection(Collection $data)
    {
        $action = $data->get('action');

        if (!$section = Request::route()->parameter('section')) {
            return;
        }

        if (!$section = Streams::entries('cp.navigation')->find($section)) {
            return;
        }

        $action = Arr::undot($action + (array) $section->route);

        if (!isset($action['stream'])) {
            $action['stream'] = $section->id;
        }
        
        $data->put('action', $action);
    }

    /**
     * Resolve the response.
     *
     * @param \Illuminate\Support\Collection $data
     */
    public function resolveResponse(Collection $data)
    {
        if ($data->has('response')) {
            return;
        }

        if (!$stream = $data->get('stream')) {
            return;
        }

        $action = $data->get('action');
        
        // @todo this needs work
        // control panel builder
        if (Arr::get($action, 'ui.cp') == true) {
            View::share('cp', (new ControlPanelBuilder())->build());
        }

        if ($component = Arr::get($action, 'ui.component')) {
        
            $component = $stream->{$component}(Arr::get($action, 'ui.handle', 'default'), [
                'entry' => $data->get('entry')
            ]);

            $data->put('response', $component->response());
        }

        parent::resolveResponse($data);
    }
}
