<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Anchor;

class AnchorTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test(Anchor::class, [
            'text' => 'Hello World',
        ])
            ->assertSee('Hello World')
            ->assertDontSee('href');

        Livewire::test(Anchor::class, [
            'text' => 'Hello World',
            'url' => '/admin',
        ])
            ->assertSee('Hello World')
            ->assertSeeHtml('href="/admin"');
    }
}
