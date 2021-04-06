<?php

namespace Streams\Ui\Table;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;

/**
 * Class TableAuthorizer
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TableAuthorizer
{

    /**
     * Authorize the table.
     *
     * @param TableBuilder $builder
     */
    public function authorize(TableBuilder $builder)
    {
        /**
         * Configured policy options
         * take precedense over the 
         * model policy.
         */
        $policy = Arr::get($builder->options, 'policy');
        $ability = Arr::get($builder->options, 'ability') ?: 'viewAny';

        $stream = $builder->stream;

        $abstract = $stream->entries()->newInstance();

        if ($policy === true) {
            $policy = $stream->policy;
        }

        if (!$policy) {
            return true;
        }

        if (is_string($policy) && class_exists($policy) && Gate::getPolicyFor($abstract)) {
            return Gate::allows($ability, $abstract);
        }
        
        if (is_string($policy) && !class_exists($policy)) {
            return Gate::allows($policy);
        }
    }
}
