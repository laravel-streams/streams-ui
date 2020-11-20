<?php

namespace Streams\Ui\Http\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Streams\Core\Http\Controller\StreamsController;
use Streams\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class CpController
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class CpController extends StreamsController
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
        
        if (isset($action['ui.component'])) {

            $component = $stream->{$action['ui.component']}([
                'entry' => $data->get('entry')
            ]);

            $data->put('response', $component->response());
        }

        parent::resolveResponse($data);
    }
}
