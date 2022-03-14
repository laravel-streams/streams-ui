<?php

namespace Streams\Ui\View;

use Illuminate\Support\Collection;

class Regions
{
    /**
     * @param Collection|array<string,Collection> $regions
     */
    public function __construct(protected Collection $regions)
    {
    }

    public function add($name)
    {
        $this->regions->put($name, new Collection());
        return $this;
    }

    public function ensure($name)
    {
        if ( ! $this->has($name)) {
            $this->add($name);
        }
        return $this->get($name);
    }

    /**
     * @param $name
     * @return Collection
     */
    public function get($name)
    {
        return $this->regions->get($name);
    }

    public function has($name)
    {
        return $this->regions->has($name);
    }

    public function hasArea(string $region, string $name)
    {
        return $this->has($region) && $this->get($region)->has($name);
    }

    public function setArea(string $region, string $name, string $view)
    {
        $content = null;
        $this->ensure($region)->put($name, (object)compact('name', 'view', 'content'));
    }

    public function setAreaContent(string $region, string $name, string $content)
    {
        $view = null;
        $this->ensure($region)->put($name, (object)compact('name', 'view', 'content'));
    }

}
