<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Components\Avatar;

class AvatarTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test(Avatar::class, [
            'src' => '/test/image.png',
        ])->assertSeeHtml('src="/test/image.png"');

        Livewire::test(Avatar::class, [
        ])->assertDontSeeHtml('src="');
    }

    public function test_it_supports_gravatars()
    {
        Livewire::test(Avatar::class, [
            'src' => 'ryan@pyrocms.com',
        ])->assertSeeHtml([
            'src="https://gravatar.com/avatar/',
            md5('ryan@pyrocms.com'),
        ]);
    }

    public function test_it_supports_query_parameters()
    {
        Livewire::test(Avatar::class, [
            'src' => 'ryan@pyrocms.com',
            'query' => [
                's' => 100,
            ],
        ])->assertSeeHtml([
            'src="https://gravatar.com/avatar/',
            md5('ryan@pyrocms.com'),
            's=100',
        ]);
    }
}
