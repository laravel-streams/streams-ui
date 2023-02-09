<?php

namespace Streams\Ui\Tests\Components\Traits;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Traits\HasAttributes;

class HasAttributesTest extends UiTestCase
{
    public function test_it_returns_html_attributes()
    {
        Livewire::component('test', HasAttributesTestComponent::class);

        Livewire::test('test')
            ->assertSee('test');
    }

    public function test_it_supports_conditional_classes()
    {
        Livewire::component('test', HasAttributesTestComponent::class);

        Livewire::test('test', [
            'attributes' => [
                'class' => [
                    'test',
                    'foo' => false,
                    'bar' => true,
                ],
            ],
        ])
            ->assertSee('test')
            ->assertSee('bar')
            ->assertDontSee('foo');
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
