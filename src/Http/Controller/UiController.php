<?php

namespace Streams\Ui\Http\Controller;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\ControlPanel\ControlPanel;
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
    public function index()
    {
        $home = (new ControlPanel())->navigation->first();

        if (!$home) {
            abort(404);
        }

        return Redirect::to($home->url());
    }

    /**
     * Handle the request.
     * 
     * @return Response
     */
    public function __invoke()
    {
        return parent::handle();
    }

    public function resolveSection(Collection $data)
    {
        $action = $data->get('action');
        $route = $data->get('route');

        if (!$section = $route->parameter('section')) {
            return;
        }
        
        if (!isset($action['stream']) && Streams::exists($section)) {

            $action['stream'] = $section;

            $data->put('action', $action);
        }

        if (!$section = Streams::entries('cp.navigation')->find($section)) {
            return;
        }
        
        $action = Arr::undot((array) $section->route + $action);

        $data->put('action', $action);
    }

    /**
     * Resolve the response.
     *
     * @param \Illuminate\Support\Collection $data
     */
    public function resolveResponse(Collection $data)
    {
        $action = $data->get('action');

        // @todo this needs work
        // control panel builder
        if (Arr::get($action, 'ui.cp_enabled') == true && !View::shared('cp')) {
            View::share('cp', new ControlPanel());
        }

        if ($data->has('response')) {
            parent::resolveResponse($data);
        }

        if (!$stream = $data->get('stream')) {
            parent::resolveResponse($data);
        }

        if ($data->get('stream') && $component = Arr::get($action, 'ui.component', request('component'))) {

            $component = $stream->ui($component, Arr::get($action, 'ui.handle', request('handle', 'default')), [
                'stream' => $data->get('stream'),
                'entry' => $data->get('entry'),
            ]);

            $data->put('response', $component->response());
        }

        parent::resolveResponse($data);
    }
}
