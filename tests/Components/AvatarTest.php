<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;

class AvatarTest extends UiTestCase
{
    public function test_it_renders()
    {
        UI::test('avatar', [
            'src' => '/test/image.png',
        ])->assertSee('src="/test/image.png"');

        UI::test('avatar', [
        ])->assertNotSee('src="');
    }

    public function test_it_supports_gravatars()
    {
        UI::test('avatar', [
            'src' => 'ryan@pyrocms.com',
        ])->assertSee([
            'src="https://gravatar.com/avatar/',
            md5('ryan@pyrocms.com'),
        ]);
    }

    public function test_it_supports_query_parameters()
    {
        $component = UI::make('avatar', [
            'src' => 'ryan@pyrocms.com',
            'query' => [
                's' => 100,
            ],
        ]);

        UI::test('avatar', [
            'src' => 'ryan@pyrocms.com',
            'query' => [
                's' => 100,
            ],
        ])->assertSee([
            'src="https://gravatar.com/avatar/',
            md5('ryan@pyrocms.com'),
            's=100',
        ])
        ->setRendered($component->src(['v' => '1.2']))
        ->assertSee([
            'https://gravatar.com/avatar/',
            md5('ryan@pyrocms.com'),
            's=100',
            'v=1.2',
        ]);
    }
}
