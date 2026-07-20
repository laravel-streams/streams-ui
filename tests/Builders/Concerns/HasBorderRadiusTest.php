<?php

namespace Streams\Ui\Tests\Builders\Concerns;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Actions\Action;

class HasBorderRadiusTest extends UiTestCase
{
    /** @test */
    public function it_builds_full_and_directional_radius_classes(): void
    {
        $action = (new Action('radius-test'))->borderRadius('2xl');

        $this->assertSame('rounded-2xl', $action->getBorderRadiusClass());
        $this->assertSame('rounded-t-2xl', $action->getBorderRadiusClass('t'));
        $this->assertSame('rounded-tl-2xl', $action->getBorderRadiusClass('tl'));
        $this->assertSame('rounded-br-2xl', $action->getBorderRadiusClass('br'));
    }

    /** @test */
    public function it_maps_radius_tokens_to_css_lengths(): void
    {
        $action = (new Action('radius-css'))->borderRadius('2xl');

        $this->assertSame('1rem', $action->getBorderRadiusCssValue());

        $action->borderRadius('none');
        $this->assertNull($action->getBorderRadiusCssValue());

        $action->borderRadius(true);
        $this->assertSame('0.25rem', $action->getBorderRadiusCssValue());
    }

    /** @test */
    public function it_passes_through_raw_rounded_classes(): void
    {
        $action = (new Action('radius-raw'))->borderRadius('rounded-3xl');

        $this->assertSame('rounded-3xl', $action->getBorderRadiusClass());
        $this->assertNull($action->getBorderRadiusCssValue());
    }
}
