<?php

namespace Streams\Ui\Tests\Components\Traits;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Components\Traits\HasAttributes;

class HasAttributesTest extends UiTestCase
{
    public function test_it_returns_attributes_array()
    {
        UI::register('test', HasAttributesTestComponent::class);

        $this->assertContains('test', UI::make('test')->attributes());
    }

    public function test_it_returns_html_attributes()
    {
        UI::register('test', HasAttributesTestComponent::class);

        $this->assertStringContainsString('class="test"', UI::make('test')->htmlAttributes());
    }

    public function test_it_supports_conditional_classes()
    {
        UI::register('test', HasAttributesTestComponent::class);

        $this->assertStringContainsString('class="test bar"', UI::make('test')->htmlAttributes([
            'class' => [
                'test',
                'foo' => false,
                'bar' => true,
            ],
        ]));
    }
}

class HasAttributesTestComponent extends \Streams\Ui\Support\Component
{
    use HasAttributes;
    
    public string $template = '';

    public array $attributes = [
        'class' => ['test'],
    ];
}
