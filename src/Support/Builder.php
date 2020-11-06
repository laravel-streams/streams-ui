<?php

namespace Streams\Ui\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Streams\Core\Support\Workflow;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\Prototype;
use Streams\Core\Support\Traits\FiresCallbacks;
use Streams\Ui\ControlPanel\ControlPanelBuilder;
use Illuminate\Support\Facades\View as FacadesView;
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
    use Prototype;
    use FiresCallbacks;

    public function build(): Builder
    {
        if ($this->instance instanceof Component) {
            return $this;
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

    public function make()
    {
        $parameters = [];//$this->getPrototypeAttributes();

        $abstract = $this->getPrototypeAttribute($this->component);

        $this->{$this->component} = new $abstract($parameters);
    }

    public function response(): HttpFoundationResponse
    {
        $this->build();

        if ($this->response) {
            return $this->response;
        }

        if (!$this->async && Request::ajax()) {
            return Response::view($this->render());
        }

        if ($this->async == true && Request::ajax()) {
            return $this->json();
        }

        FacadesView::share('cp', (new ControlPanelBuilder())->build()->instance);

        return Response::view('ui::default', ['content' => $this->render()]);
    }

    public function render(): View
    {
        $this->build();

        return $this->instance->render();
    }

    public function json(): JsonResponse
    {
        $this->build();

        return Response::json($this->instance->toJson());
    }


    protected function workflow($name): Workflow
    {
        $workflow = Arr::get($this->workflows, $name, $name);

        if (!class_exists($workflow)) {
            $workflow = $this->workflow;
        }

        if (!$workflow) {
            return (new Workflow($this->steps ?: []))
                ->setPrototypeAttribute('name', $name)
                ->passThrough($this);
        }

        return (new $workflow)
            ->setPrototypeAttribute('name', $name)
            ->passThrough($this);
    }

    protected function loadInstanceWith($key, $input, $abstract)
    {
        return array_map(function ($attributes) use ($key, $abstract) {
            
            $abstract = Arr::pull($attributes, 'abstract', $abstract);

            $this->instance->{$key}->put($attributes['handle'], new $abstract($attributes));
        }, $input);
    }

    public function __get($key)
    {
        if ($key == 'instance') {
            $key  = $this->__prototype['attributes']['component'];
        }

        return $this->getPrototypeAttribute($key);
    }

    public function __set($key, $value)
    {
        if ($key == 'instance') {
            $key  = $this->__prototype['attributes']['component'];
        }

        $this->setPrototypeAttribute($key, $value);
    }

    public function __call($method, $parameters)
    {
        if (method_exists($this->instance, $method)) {
            return call_user_func_array([$this->instance, $method], $parameters);
        }

        throw new \Exception("Method [{$method}] does not exist.");
    }
}
