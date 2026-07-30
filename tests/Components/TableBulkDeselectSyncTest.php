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

    /** @test */
    public function escape_key_deselects_all_when_no_modal_is_open(): void
    {
        $tableJs = file_get_contents(
            dirname(__DIR__, 2).'/resources/js/components/table.js'
        );

        $this->assertStringContainsString('handleEscapeKey', $tableJs);
        $this->assertStringContainsString('hasOpenOverlay', $tableJs);
        $this->assertStringContainsString(
            "window.addEventListener('keydown', this._onEscapeKey)",
            $tableJs,
        );
        $this->assertStringContainsString(
            'this.deselectAllEntries()',
            $tableJs,
        );
        $this->assertStringContainsString(
            "if (event.key !== 'Escape')",
            $tableJs,
        );
    }

    /** @test */
    public function selected_state_path_ignores_blank_and_leading_dot_paths(): void
    {
        $tableJs = file_get_contents(
            dirname(__DIR__, 2).'/resources/js/components/table.js'
        );

        $this->assertStringContainsString(
            "! this.selectedStatePath.startsWith('.')",
            $tableJs,
        );
        $this->assertStringContainsString(
            "if (! path || path === '' || path.startsWith('.'))",
            $tableJs,
        );
    }
}
