<?php

namespace Anomaly\Streams\Ui\Support;

use Illuminate\Support\Arr;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Traits\Macroable;
use Anomaly\Streams\Platform\Support\Workflow;
use Anomaly\Streams\Platform\Support\Traits\Properties;
use Anomaly\Streams\Platform\Support\Traits\FiresCallbacks;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

/**
 * Class Builder
 * 
 * Builders build component (UI objects) instances.
 * 
 * Intended to be instantiated like:
 * 
 * $builder = new FormBuilder($attributes);
 * 
 * Available Methods
 * 
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

    public function build(): Builder
    {
        if ($this->instance instanceof Component) {
            $this->instance;
        }

        $this->fire('ready', ['builder' => $this]);

        $workflow = $this->workflow('build');

        $this->fire('building', [
            'builder' => $this,
            'workflow' => $workflow
        ]);

        $workflow->process([
            'builder' => $this,
            'workflow' => $workflow
        ]);

        $this->fire('built', ['builder' => $this]);

        return $this;
    }

    public function render(): View
    {
        $this->build();

        return $this->instance->render();
    }

    public function response(): HttpFoundationResponse
    {
        $this->build();

        if ($this->response) {
            return $this->response;
        }

        if ($this->async == true && Request::ajax()) {
            return $this->json();
        }

        return Response::view('ui::default', ['content' => $this->render()]);
    }

    public function json(): JsonResponse
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

    protected function workflow($name): Workflow
    {
        $workflow = Arr::get($this->workflows, $name);

        if (!class_exists($workflow)) {
            throw new \Exception("Workflow [{$name}] does not exist.");
        }

        return (new $workflow)
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
