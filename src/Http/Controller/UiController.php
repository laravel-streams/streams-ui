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

        $action = array_merge((array) $section->route, $action);

        if (!isset($action['stream']) && $section->stream) {
            $action['stream'] = $section->stream;
        }

        $data->put('action', $action);
    }

    protected function resolveEntry(Collection $data): void
    {
        if (!$stream = $data->get('stream')) {
            return;
        }

        if ($data->has('entry')) {
            return;
        }

        if ($entry = Request::query('entry')) {

            $data->put('entry', $stream->repository()->find($entry));

            return;
        }

        parent::resolveEntry($data);
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

        $component = Arr::get($action, 'ui.component', request('component'));

        if ($component && $configuration = Arr::get($action, 'ui.' . $component)) {
            $data->put('response', UI::make($component, $configuration)->response());
        }

        if (!$stream = $data->get('stream')) {
            parent::resolveResponse($data);
        }

        if ($stream && $component) {

            $component = $stream->ui($component, Arr::get($action, 'ui.handle', $handle = request('handle', 'default')), [
                'stream' => $stream,
                'entry' => $data->get('entry'),
                'handle' => $handle,
            ]);

            $data->put('response', $component->response());
        }

        if (!$stream && $generic = Arr::get($action, 'ui.component', request('component'))) {

            $generic = UI::make($generic, Request::query());

            $data->put('response', $generic->response());
        }

        parent::resolveResponse($data);
    }
}
