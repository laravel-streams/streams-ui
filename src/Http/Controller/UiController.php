<?php

namespace Streams\Ui\Http\Controller;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Streams\Ui\Support\Facades\UI;
use Illuminate\Support\Facades\View;
use Illuminate\Http\RedirectResponse;
use Streams\Ui\Components\ControlPanel;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Http\Controller\EntryController;

class UiController extends EntryController
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

    public function __invoke()
    {
        $data = collect();

        $data->put('route', Request::route());
        $data->put('action', Request::route()->action);

        $this->resolveSection($data);

        $this->resolveStream($data);
        $this->resolveEntry($data);
        
        $this->resolveView($data);
        $this->resolveRedirect($data);
        $this->resolveResponse($data);

        return $data->get('response') ?: abort(404);
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

        if (!$section = Streams::repository('cp.navigation')->find($section)) {
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
    public function resolveResponse(Collection $data): void
    {
        $action = $data->get('action');

        // @todo this needs work
        // control panel builder
        if (Arr::get($action, 'ui.cp_enabled') == true && !View::shared('cp')) {
            View::share('cp', UI::make('cp'));
        }

        if ($data->has('response')) {
            parent::resolveResponse($data);
        }

        if (!$stream = $data->get('stream')) {
            parent::resolveResponse($data);
        }

        if ($stream && $component = Arr::get($action, 'ui.component', request('component'))) {

            $component = $stream->ui($component, Arr::get($action, 'ui.handle', request('handle', 'default')), [
                'stream' => $stream,
                'entry' => $data->get('entry'),
            ]);

            $data->put('response', $component->response());
        }

        parent::resolveResponse($data);
    }
}
