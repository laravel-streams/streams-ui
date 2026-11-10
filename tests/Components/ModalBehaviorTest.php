<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;

class ModalBehaviorTest extends UiTestCase
{
    /** @test */
    public function modal_exposes_root_and_backdrop_hooks(): void
    {
        $modal = file_get_contents(
            dirname(__DIR__, 2).'/resources/views/components/modal/index.blade.php'
        );

        $this->assertStringContainsString('data-ui-modal-root', $modal);
        $this->assertStringContainsString('data-ui-modal-backdrop', $modal);
    }

    /** @test */
    public function modal_guards_dirty_forms_with_keep_editing_and_discard(): void
    {
        $modal = file_get_contents(
            dirname(__DIR__, 2).'/resources/views/components/modal/index.blade.php'
        );

        $this->assertStringContainsString('Discard unsaved changes?', $modal);
        $this->assertStringContainsString('Keep editing', $modal);
        $this->assertStringContainsString('Discard', $modal);
        $this->assertStringContainsString('data-ui-modal-dirty-guard', $modal);
        $this->assertStringContainsString('data-ui-modal-dirty-keep-editing', $modal);
        $this->assertStringContainsString('data-ui-modal-dirty-discard', $modal);
        $this->assertStringContainsString('requestClose: function', $modal);
        $this->assertStringContainsString('keepEditing: function', $modal);
        $this->assertStringContainsString('discardChanges: function', $modal);
        $this->assertStringContainsString('isDirty: function', $modal);
    }

    /** @test */
    public function opening_a_modal_pushes_history_and_back_closes_it(): void
    {
        $modal = file_get_contents(
            dirname(__DIR__, 2).'/resources/views/components/modal/index.blade.php'
        );

        $this->assertStringContainsString('history.pushState', $modal);
        $this->assertStringContainsString('handlePopstate: function', $modal);
        $this->assertStringContainsString("addEventListener('popstate'", $modal);
        $this->assertStringContainsString('history.back()', $modal);
    }
}
