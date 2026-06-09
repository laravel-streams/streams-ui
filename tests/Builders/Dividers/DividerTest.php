<?php

namespace Streams\Ui\Tests\Builders\Dividers;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Dividers\Divider;

class DividerTest extends UiTestCase
{
    /** @test */
    public function it_can_be_made_and_renders_a_faint_horizontal_rule(): void
    {
        $html = Divider::make()->toHtml();

        $this->assertStringContainsString('role="separator"', $html);
        $this->assertStringContainsString('bg-gray-900/15', $html);
        $this->assertStringContainsString('h-px', $html);
    }

    /** @test */
    public function it_merges_html_attributes(): void
    {
        $html = Divider::make()
            ->mergeHtmlAttributes(['class' => 'my-2'])
            ->toHtml();

        $this->assertStringContainsString('my-2', $html);
    }
}
