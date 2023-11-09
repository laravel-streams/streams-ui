<?php

namespace Streams\Ui\Components;

use Streams\Core\Field\Field;
use Streams\Ui\Components\Anchor;

class Button extends Anchor
{
    public string $tag = 'button';

    public ?string $name = null;

    #[Field([
        'type' => 'select',
        'config' => [
            'options' => [
                'submit' => 'Submit',
                'reset' => 'Reset',
                'button' => 'Button',
            ],
        ],
    ])]
    public string $type = 'button';

    public bool $disabled = false;

    public $value = null;

    // #[Field([
    //     'type' => 'select',
    //     'config' => [
    //         'options' => [
    //             'xs' => 'XS',
    //             'sm' => 'SM',
    //             'md' => 'MD',
    //             'lg' => 'LG',
    //         ],
    //     ],
    // ])]
    // public string $size = 'md';

    public function render()
    {
        return view('ui::components.button');
    }

    static public function make(array $attributes)
    {
        $static = new static();

        foreach ($attributes as $key => $value) {
            $static->{$key} = $value;
        }

        return $static;
    }
}
