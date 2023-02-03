<?php

namespace Streams\Ui\Tests\Support;

use Streams\Ui\Button\Button;
use Streams\Ui\Support\Value;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Component;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\View\ViewTemplate;

class ValueTest extends UiTestCase
{
    public function test_it_parses_values()
    {
        $this->assertSame('Foo Bar', Value::make('Foo {entry.name}', [
            'name' => 'Bar',
        ]));

        $this->assertSame(['Foo Bar'], Value::make(['value' => ['Foo {entry.name}']], [
            'name' => 'Bar',
        ]));
    }

    public function test_it_supports_object_properties()
    {
        $this->assertSame('Bar', Value::make('name', json_decode(json_encode([
            'name' => 'Bar',
        ]), false)));
    }

    public function test_it_renders_views()
    {
        $view = ViewTemplate::path('Rendered: {{ $value }}');
        
        $this->assertSame('Rendered: Bar', Value::make([
            'view' => $view,
            'value' => 'name',
        ], ['name' => 'Bar']));
    }

    public function test_it_renders_templates()
    {
        $template = 'Rendered: {{ $value }}';
        
        $this->assertSame('Rendered: Bar', Value::make([
            'template' => $template,
            'value' => 'name',
        ], ['name' => 'Bar']));
    }
}
