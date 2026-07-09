<?php

namespace Streams\Ui\Tests\Builders\Images;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Images\Image;

class ImageTest extends UiTestCase
{
    /** @test */
    public function it_renders_a_basic_image_with_alt_text(): void
    {
        $html = Image::make('/img/logo.svg')
            ->alt('GroupVitals')
            ->mergeHtmlAttributes(['class' => 'h-8 w-auto'])
            ->toHtml();

        $this->assertStringContainsString('src="/img/logo.svg"', $html);
        $this->assertStringContainsString('alt="GroupVitals"', $html);
        $this->assertStringContainsString('class="h-8 w-auto"', $html);
    }

    /** @test */
    public function it_renders_a_linked_image_with_wrapper_attributes(): void
    {
        $html = Image::make('/img/logo.svg')
            ->alt('GroupVitals')
            ->url('/')
            ->linkAriaLabel('Go home')
            ->mergeHtmlAttributes(['class' => 'h-8 w-auto'])
            ->mergeWrapperHtmlAttributes(['class' => 'inline-flex shrink-0 items-center'])
            ->toHtml();

        $this->assertStringContainsString('href="/"', $html);
        $this->assertStringContainsString('aria-label="Go home"', $html);
        $this->assertStringContainsString('inline-flex shrink-0 items-center', $html);
        $this->assertStringContainsString('<img', $html);
    }

    /** @test */
    public function it_renders_lazy_loading_when_enabled(): void
    {
        $html = Image::make('/img/logo.svg')
            ->alt('GroupVitals')
            ->lazy()
            ->toHtml();

        $this->assertStringContainsString('loading="lazy"', $html);
    }

    /** @test */
    public function it_renders_nothing_when_hidden(): void
    {
        $html = Image::make('/img/logo.svg')
            ->alt('GroupVitals')
            ->hidden()
            ->toHtml();

        $this->assertSame('', trim($html));
    }
}
