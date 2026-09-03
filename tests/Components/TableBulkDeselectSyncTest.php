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
            'this.dismissBulkSelection()',
            $tableJs,
        );
        $this->assertStringContainsString(
            'deselectAllTableRecords',
            $tableJs,
        );
        $this->assertStringContainsString(
            '_dismissedSelection',
            $tableJs,
        );
        $this->assertStringContainsString(
            "if (event.key !== 'Escape')",
            $tableJs,
        );
    }

    /** @test */
    public function escape_dismissal_skips_livewire_selected_sync_and_clears_matching_mode(): void
    {
        $tableJs = file_get_contents(
            dirname(__DIR__, 2).'/resources/js/components/table.js'
        );

        $this->assertStringContainsString('dismissBulkSelection: function', $tableJs);
        $this->assertStringContainsString('this.clearSelectAllMatching()', $tableJs);
        $this->assertStringContainsString(
            'this.deselectAllEntries({ sync: false })',
            $tableJs,
        );
        $this->assertStringNotContainsString(
            "handleEscapeKey: function (event) {\n            if (event.key !== 'Escape') {\n                return\n            }\n\n            if (this.selectedEntries.length === 0 && ! this.selectAllMatching) {\n                return\n            }\n\n            // Let open modals / dropdowns consume Escape first.\n            if (this.hasOpenOverlay()) {\n                return\n            }\n\n            this.deselectAllEntries()",
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

    /** @test */
    public function select_all_checkbox_is_driven_from_selection_state_not_native_toggle(): void
    {
        $tableJs = file_get_contents(
            dirname(__DIR__, 2).'/resources/js/components/table.js'
        );

        $this->assertStringContainsString('addEventListener(\'click\', this._onSelectAllClick, true)', $tableJs);
        $this->assertStringContainsString('addEventListener(\'change\', this._onSelectAllChange, true)', $tableJs);
        $this->assertStringContainsString('event.stopPropagation()', $tableJs);
        $this->assertStringContainsString('checkbox.setAttribute(\'aria-checked\'', $tableJs);
        $this->assertStringContainsString(
            'Never trust the native checked flag',
            $tableJs,
        );
        $this->assertStringContainsString(
            'Decide from selection state only — never from checkbox.checked.',
            $tableJs,
        );
    }

    /** @test */
    public function selection_hydrates_from_livewire_public_state_across_remorphs(): void
    {
        $tableJs = file_get_contents(
            dirname(__DIR__, 2).'/resources/js/components/table.js'
        );
        $tableBlade = file_get_contents(
            dirname(__DIR__, 2).'/resources/views/builders/table.blade.php'
        );

        $this->assertStringContainsString('hydrateSelectionFromPublicState', $tableJs);
        $this->assertStringContainsString('readSelectedKeysFromLivewire', $tableJs);
        $this->assertStringContainsString('data-selected-keys', $tableBlade);
        $this->assertStringContainsString('data-select-all-matching', $tableBlade);
        $this->assertStringContainsString("x-data=\"table('{{ \$tableName }}', @js(\$selectedStatePath))\"", $tableBlade);
        $this->assertStringNotContainsString('state.matchingTotalCount =', $tableBlade);
        $this->assertStringContainsString("[...this.selectedEntries],\n                false,", $tableJs);
    }

    /** @test */
    public function bulk_actions_receive_paged_selected_entries_instead_of_query_builders(): void
    {
        $bulkActions = file_get_contents(
            dirname(__DIR__, 2).'/src/Livewire/Tables/Concerns/HasBulkActions.php'
        );
        $bulkAction = file_get_contents(
            dirname(__DIR__, 2).'/src/Builders/Tables/BulkActions/BulkAction.php'
        );

        $this->assertStringContainsString('getBulkActionSelectedEntryPages', $bulkActions);
        $this->assertStringContainsString('resolveBulkActionChunkSize', $bulkActions);
        $this->assertStringContainsString('return 100;', $bulkActions);
        $this->assertStringContainsString('snapshotFilteredSortedEntryKeys', $bulkActions);
        $this->assertStringContainsString('foreach ($pages as $index => $selectedEntries)', $bulkActions);
        $this->assertStringContainsString("'bulk_page' => \$index + 1", $bulkActions);
        $this->assertStringNotContainsString("'selectAllMatching' => \$selectAllMatching", $bulkActions);
        $this->assertStringNotContainsString("'query' => \$this->getFilteredSortedQuery", $bulkActions);
        $this->assertStringNotContainsString("'selectAllMatching' =>", $bulkAction);
        $this->assertStringContainsString('Do not re-read Livewire page checkboxes', $bulkAction);
        $this->assertStringNotContainsString('getSelectedTableEntries($tableName)', $bulkAction);
    }

    /** @test */
    public function matching_total_uses_filtered_table_entries_and_clones_query(): void
    {
        $tablePhp = file_get_contents(
            dirname(__DIR__, 2).'/src/Builders/Tables/Table.php'
        );
        $bulkActions = file_get_contents(
            dirname(__DIR__, 2).'/src/Livewire/Tables/Concerns/HasBulkActions.php'
        );
        $paginate = file_get_contents(
            dirname(__DIR__, 2).'/src/Livewire/Tables/Concerns/CanPaginateEntries.php'
        );
        $tableJs = file_get_contents(
            dirname(__DIR__, 2).'/resources/js/components/table.js'
        );

        $this->assertStringContainsString('return clone $query;', $tablePhp);
        $this->assertStringContainsString('syncMatchingTotalState', $tablePhp);
        $this->assertStringContainsString("getStatePath().'.matching_total'", $tablePhp);
        $this->assertStringContainsString('$livewire->data = $livewire->data;', $tablePhp);
        $this->assertStringContainsString('method_exists($entries, \'total\')', $bulkActions);
        $this->assertStringContainsString('syncMatchingTotalFromPublicState', $tableJs);
        $this->assertStringContainsString('getMatchingTotalStatePath', $tableJs);
        $this->assertStringContainsString('! this.selectAllMatching && this.readMatchingTotalFromDom()', $tableJs);
        $this->assertStringContainsString('_matchingTotalObserver', $tableJs);
        $this->assertStringContainsString("attributeFilter: ['data-matching-total']", $tableJs);
        $this->assertStringContainsString("this.\$wire.\$hook('commit'", $tableJs);
        $this->assertStringContainsString('$wire?.__instance', $tableJs);
        $this->assertStringContainsString('persistSelectAllMatching', $tableJs);
        $this->assertStringContainsString("str_starts_with(\$field, 'filters.')", $paginate);
    }
}
