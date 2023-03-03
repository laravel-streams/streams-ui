<?php

namespace Streams\Ui\Tests\Components\Traits;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Components\Traits\HasAttributes;

class HasAttributesTest extends UiTestCase
{
    public function test_it_returns_html_attributes()
    {
        UI::component('test', HasAttributesTestComponent::class);

        UI::test('test')
            ->render()
            ->assertSee('class="test"');
    }

    public function test_it_supports_conditional_classes()
    {
        UI::component('test', HasAttributesTestComponent::class);

        UI::test('test', [
            'attributes' => [
                'class' => [
                    'test',
                    'foo' => false,
                    'bar' => true,
                ],
            ],
        ])
        ->render()
        ->assertSee(['test', 'bar'])
        ->assertNotSee('foo');
    }
}

class HasAttributesTestComponent extends \Streams\Ui\Support\Component
{
    use HasAttributes;

    public string $template = <<<'blade'
    <div>
        <button {{ $component->htmlAttributes() }}>{{ $component->text }}</button>
    </div>
    blade;

    public ?string $text = null;

    public array $attributes = [
        'class' => ['test'],
    ];
}
