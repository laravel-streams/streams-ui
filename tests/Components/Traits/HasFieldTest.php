<?php

namespace Streams\Ui\Tests\Components\Traits;

use Streams\Core\Field\Field;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Components\Traits\HasField;
use Streams\Ui\Components\Traits\HasStream;

class HasFieldTest extends UiTestCase
{
    public function test_it_returns_fields()
    {
        UI::component('test', HasFieldTestComponent::class);

        $this->assertNull(UI::test('test')->field());

        $this->assertInstanceOf(Field::class, UI::test('test', [
            'stream' => 'films',
            'field' => 'title',
        ])->field());
    }
}

class HasFieldTestComponent extends \Streams\Ui\Support\Component
{
    use HasStream;
    use HasField;

    public ?string $stream = null;
    public ?string $field = null;

    public string $template = '';
}
