<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;

class NavigationGroup extends Component
{
    public string $name;
    public string $label;

    public function render(array $payload = []): \Illuminate\View\View|string
    {
        return view('ui::components.navigation_group');
    }
}
