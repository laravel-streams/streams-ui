<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;

class MessagesStackingTest extends UiTestCase
{
    /** @test */
    public function messages_use_z_index_above_modal_backdrop(): void
    {
        $messages = file_get_contents(
            dirname(__DIR__, 2).'/resources/views/components/messages/index.blade.php'
        );
        $modal = file_get_contents(
            dirname(__DIR__, 2).'/resources/views/components/modal/index.blade.php'
        );

        $this->assertStringContainsString('x-teleport="body"', $messages);
        $this->assertStringContainsString('z-[60]', $messages);
        $this->assertStringNotContainsString('class="z-50 ', $messages);

        $this->assertStringContainsString('x-teleport="body"', $modal);
        $this->assertStringContainsString("'fixed inset-0 z-50 ", $modal);
        $this->assertStringNotContainsString('z-[60]', $modal);
    }
}
