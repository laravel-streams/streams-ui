<?php

namespace Streams\Ui\Blade\Components;

use Streams\Ui\Components\Button;
use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class ButtonComponent extends Component
{
    public function render()
    {
        return function (array $data) {
            
            $button = new Button($data['attributes']->getAttributes());

            if ($data['slot']->isNotEmpty()) {
                $button->text = $data['slot'];
            }
     
            return View::make('ui::components.button', [
                'button' => $button,
            ])->render();
        };
        
    }
}
