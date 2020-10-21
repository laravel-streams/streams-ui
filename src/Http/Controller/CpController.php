<?php

namespace Streams\Ui\Http\Controller;

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

    public function index()
    {
        dd(__CLASS__);
    }
}
