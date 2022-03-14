<?php

namespace Streams\Ui\View;

use InvalidArgumentException;

class ManagesAreas
{
    public array $areaStack = [];

    public ?Regions $regions = null;

    public function regions(): Regions
    {
        if ( ! $this->regions) {
            $this->regions = resolve(Regions::class);
        }
        return $this->regions;
    }

    public function startArea()
    {
        $me = $this;
        return function ($regionName, $areaName, string $view = null) use (&$me) {
            if ($view === null) {
                if (ob_start()) {
                    $me->areaStack[] = compact('regionName', 'areaName', 'view');
                }
            } else {
                $me->areaStack[] = compact('regionName', 'areaName', 'view');
            }
        };
    }

    public function stopArea()
    {
        $me = $this;
        return function () use ($me) {
            if (empty($me->areaStack)) {
                throw new InvalidArgumentException('Cannot end a area stack without first starting one.');
            }

            return tap(array_pop($me->areaStack), function ($last) use ($me) {
                $area = (object)[
                    'name'    => $last[ 'areaName' ],
                    'view'    => $last[ 'view' ],
                    'content' => null,
                ];
                if ($last[ 'view' ] === null) {
                    $area->content = ob_get_clean();
                }
                $region = $me->regions()->ensure($last[ 'regionName' ]);
                // if area exist, then this has been done from service provider with the purpose of overriding this directives area
                if ( ! $region->has($area->name)) {
                    $region->put($area->name, $area);
                }
            });
        };
    }

    public function yieldRegionContent()
    {
        $me = $this;
        return function ($name) use ($me) {
            $areas   = $me->regions()->ensure($name)->all();
            $content = '';
            foreach ($areas as $area) {
                if ($area->view !== null) {
                    $content .= view($area->view)->render();
                } elseif ($area->content !== null) {
                    $content .= $area->content;
                }
            }
            return $content;
        };
    }

    public function flushAreas()
    {
        $me = $this;
        return function () use ($me) {
            $me->areaStack = [];
        };
    }
}
