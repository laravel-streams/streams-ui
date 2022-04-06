<?php

namespace Streams\Ui\Components\ControlPanel\Navigation;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Collective\Html\HtmlFacade;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\URL;

class Section extends Component
{

    public string $component = 'section';

    public ?string $title = null;
    public ?string $policy = null;

    public bool $active = false;

    public $buttons = [];

    public function url(array $extra = [])
    {
        $target = Arr::get($this->attributes, 'href') ?: ('@cp/' . $this->id);

        if (Str::startsWith($target, '@cp/')) {
            return URL::cp(ltrim(substr($target, 4), '/'), $extra);
        }

        return URL::to($target);
    }

    public function link(array $attributes = [])
    {
        return HtmlFacade::link(
            $this->url(),
            $this->title,
            $this->htmlAttributes($attributes)
        );
    }

    public function render(array $payload = [])
    {
        return $this->link();
    }
}
