<?php

namespace Streams\Ui\Http\Controller;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Streams\Core\Http\Controller\StreamsController;

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

            $data->put('response', $stream->{$action['ui.component']}(
                $data->filter()->except('stream')->all()
            )->response());

            return;
        }

        parent::resolveResponse($data);
    }
}
