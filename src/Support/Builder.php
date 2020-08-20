<?php

namespace Anomaly\Streams\Ui\Support;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Traits\Macroable;
use Anomaly\Streams\Platform\Support\Workflow;
use Anomaly\Streams\Ui\Support\Workflows\SetStream;
use Anomaly\Streams\Ui\Support\Workflows\LoadAssets;
use Anomaly\Streams\Ui\Support\Workflows\SetOptions;
use Anomaly\Streams\Platform\Support\Traits\Properties;
use Anomaly\Streams\Ui\Support\Workflows\MakeComponent;
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

    protected $workflows = [
        'build' => [
            MakeComponent::class,
            LoadAssets::class,
            SetStream::class,
            SetOptions::class,
        ]
    ];

    /**
     * Build and return the instance instance.
     *
     * @return $this
     */
    public function build()
    {
        $this->fire('ready', ['builder' => $this]);

        $workflow = $this->newWorkflow('build');

        $this->fire('building', [
            'builder' => $this,
            'workflow' => $workflow
        ]);

        $workflow->process(['builder' => $this, 'workflow' => $workflow]);

        $this->fire('built', ['builder' => $this]);

        return $this->instance;
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
        return Request::get($this->instance->prefix($key), $default);
    }

    protected function newWorkflow($name): Workflow
    {
        return (new Workflow($this->workflows[$name]))
            ->setAttribute('name', $name)
            ->passThrough($this);
    }

    public function __get($key)
    {

        if ($key == 'instance') {
            $key  = $this->attributes['component'];
        }

        return $this->getAttribute($key);
    }

    public function __set($key, $value)
    {
        if ($key == 'instance') {
            $key  = $this->attributes['component'];
        }

        $this->setAttribute($key, $value);
    }
}
