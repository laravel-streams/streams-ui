<?php

namespace Streams\Ui\Http\Controller;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
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
        
        $action = Request::route()->action;

        // @todo this needs work
        // control panel builder
        if (isset($action['ui.cp']) && $action['ui.cp'] == true) {
            View::share('cp', (new ControlPanelBuilder())->build());
        }
        
        if (isset($action['ui.component'])) {

            $component = $stream->{$action['ui.component']}([
                'entry' => $data->get('entry')
            ]);

            $data->put('response', $component->response());
        }

        parent::resolveResponse($data);
    }
}
