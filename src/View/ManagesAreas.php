<?php

namespace Streams\Ui\View;

use InvalidArgumentException;

class ManagesAreas
{
    public array $areaStack = [];


    public function startArea()
    {
        $me = $this;

        return
            /**
             * @param string $region The name of the region
             * @param string $name The name to define this area
             * @param string|null $view The view name to use instead of content
             */
            function (string $region, string $name, string $view = null) use (&$me) {
            if ($view === null) {
                if (ob_start()) {
                    $me->areaStack[] = compact('region', 'name', 'view');
                }
            } else {
                $me->areaStack[] = compact('region', 'name', 'view');
            }
        };
    }

    public function stopArea()
    {
        $me = $this;
        return  function () use ($me) {
            if (empty($me->areaStack)) {
                throw new InvalidArgumentException('Cannot end a area stack without first starting one.');
            }

            return tap(array_pop($me->areaStack), static function ($last) use ($me) {
                $area = (object)[
                    'name'    => $last[ 'name' ],
                    'view'    => $last[ 'view' ],
                    'content' => null,
                ];
                if ($last[ 'view' ] === null) {
                    $area->content = ob_get_clean();
                }
                $region = resolve(Regions::class)->ensure($last[ 'region' ]);
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
        return function (string $name) use ($me) {
            $areas   = resolve(Regions::class)->ensure($name)->all();
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
