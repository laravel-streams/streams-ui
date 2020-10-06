<?php

namespace Anomaly\Streams\Ui\View\Component\Cp;

use Illuminate\View\Component;

class NavigationLink extends Component
{
    public $href;
    public $link;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($href = null, $link)
    {
        $this->href = $href;
        $this->link = $link;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('ui::components.cp.navigation_link');
    }
}
