<?php

namespace Streams\Ui\Tests\Builders\Display;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Display\Entry;
use Streams\Ui\Builders\Display\Display;
use Streams\Ui\Builders\Actions\Action;

class DisplayBuilderTest extends UiTestCase
{
    /** @test */
    public function it_renders_entries_from_fill_with_a_header_action_and_no_inputs(): void
    {
        $display = Display::make([Entry::make('name'), Entry::make('email', 'Contact')])
            ->heading('Profile')
            ->actions([Action::make('edit')->label('Edit')])
            ->fill(['name' => 'Acme Person', 'email' => 'a@example.com']);

        $html = $display->toHtml();

        $this->assertStringContainsString('Acme Person', $html);
        $this->assertStringContainsString('Contact', $html);
        $this->assertStringContainsString('a@example.com', $html);
        $this->assertStringContainsString('Edit', $html);
        $this->assertStringNotContainsString('<input', $html);
        $this->assertStringNotContainsString('<textarea', $html);
        $this->assertStringNotContainsString('<select', $html);
    }
}
