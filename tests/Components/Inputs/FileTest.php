<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Components\Inputs\File;
use Streams\Core\Support\Facades\Streams;

class FileTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(File::class, UI::make('file'));
    }

    public function test_it_renders()
    {
        $output = UI::make('file', [
            'name' => 'test',
            'placeholder' => 'Example',
        ])->render();

        $this->assertStringContainsString('type="file"', $output);
    }
}
