<?php

namespace Streams\Ui\Tests\Support;

use Streams\Ui\Tests\UiTestCase;
use Illuminate\Support\Collection;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Button\Button;

class ButtonTest extends UiTestCase
{

    public function test_it_opens_its_tag()
    {
        $component = new Button();

        $this->assertStringStartsWith('<a', $component->open());
    }

    public function test_it_supports_attributes()
    {
        $component = new Button();

        $this->assertStringContainsString('foo="bar"', $component->open([
            'foo' => 'bar',
        ]));
    }

    public function test_it_closes_its_tag()
    {
        $component = new Button();

        $this->assertSame('</a>', $component->close());
    }

    public function test_it_returns_urls()
    {
        $component = new Button([
            'href' => '#test',
        ]);

        $this->assertSame(url('#test'), $component->url());
    }

    public function test_it_returns_text()
    {
        $component = new Button([
            'text' => 'Foo Bar',
        ]);

        $this->assertSame('Foo Bar', $component->text());
    }

    public function test_it_returns_humanized_handle_as_text_default()
    {
        $component = new Button([
            'handle' => 'foo_bar',
        ]);

        $this->assertSame('Foo Bar', $component->text());
    }

    public function test_it_can_disable_text()
    {
        $component = new Button([
            'text' => false,
        ]);

        $this->assertNull($component->text());
    }
}
