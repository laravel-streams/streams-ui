<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;

class TableBulkDeselectSyncTest extends UiTestCase
{
    /** @test */
    public function server_driven_deselect_skips_selected_entries_livewire_sync(): void
    {
        $tableJs = file_get_contents(
            dirname(__DIR__, 2).'/resources/js/components/table.js'
        );

        $this->assertStringContainsString('suppressSelectedSync', $tableJs);
        $this->assertStringContainsString(
            "this.deselectAllEntries({ sync: false })",
            $tableJs,
        );
        $this->assertStringContainsString(
            'if (this.suppressSelectedSync)',
            $tableJs,
        );
    }
}
