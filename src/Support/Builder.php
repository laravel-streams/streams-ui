<?php

namespace Anomaly\Streams\Ui\Support;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Traits\Macroable;
use Anomaly\Streams\Platform\Support\Traits\Properties;
use Anomaly\Streams\Platform\Support\Traits\FiresCallbacks;

/**
 * Class Builder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
 class Builder
{
    use Macroable;
    use Properties;
    use FiresCallbacks;

    /**
     * Build and return the instance instance.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->built === true) {
            return $this;
        }

        $this->fire('ready', ['builder' => $this]);

        $workflow = new $this->build_workflow;

        $this->fire('build', [
            'builder' => $this,
            'workflow' => $workflow
        ]);

        $workflow->process(['builder' => $this]);

        $this->fire('built', ['builder' => $this]);

        $this->built = true;

        return $this;
    }

    /**
     * Render the instance.
     *
     * @return View
     */
    public function render()
    {
        $this->build();

        return $this->instance->render();
    }

    /**
     * Return the instance response.
     * 
     * @return Response
     */
    public function response()
    {
        if ($this->async == true && Request::ajax()) {
            return $this->json();
        }

        return Response::view('streams::default', ['content' => $this->render()]);
    }

    /**
     * Return a JSON response.
     *
     * @return JsonResponse
     */
    public function json()
    {
        $this->build();

        return Response::json($this->instance->toJson());
    }

    /**
     * Get a request value.
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function request($key, $default = null)
    {
        return Request::get($this->instance->options->get('prefix') . $key, $default);
    }

    /**
     * Get a post value.
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function post($key, $default = null)
    {
        return Request::post($this->instance->options->get('prefix') . $key, $default);
    }

    /**
     * @todo eventually remove these get/set magics
     * Dynamically retrieve attributes.
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {

        if ($key == 'instance') {
            $key  = $this->attributes['component'];
        }

        return $this->getAttribute($key);
    }

    /**
     * Dynamically set attributes.
     *
     * @param string  $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        if ($key == 'instance') {
            $key  = $this->attributes['component'];
        }

        $this->setAttribute($key, $value);
    }
}
