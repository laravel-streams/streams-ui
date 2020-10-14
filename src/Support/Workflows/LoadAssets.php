<?php

namespace Streams\Ui\Support\Workflows;

use Streams\Ui\Support\Builder;
use Streams\Core\Support\Facades\Assets;

/**
 * Class LoadAssets
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class LoadAssets
{

    /**
     * Handle the command.
     *
     * @param Builder $builder
     */
    public function handle(Builder $builder)
    {
        if (!$builder->assets) {
            return;
        }

        foreach ($builder->assets as $collection => $assets) {
            Assets::collection($collection)->merge($assets);
        }
    }
}
