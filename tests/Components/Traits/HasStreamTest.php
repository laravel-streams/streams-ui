<?php

namespace Streams\Ui\Tests\Components\Traits;

use Streams\Core\Stream\Stream;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Components\Traits\HasStream;

class HasStreamTest extends UiTestCase
{
    public function test_it_returns_streams()
    {
        UI::component('test', HasStreamTestComponent::class);

        $this->assertNull(UI::test('test')->stream());

        $this->assertInstanceOf(Stream::class, UI::test('test', [
            'stream' => 'films',
        ])->stream());
    }
}

class HasStreamTestComponent extends \Streams\Ui\Support\Component
{
    use HasStream;

    public ?string $stream = null;

    public string $template = '';
}
