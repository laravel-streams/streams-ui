<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Component;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;

class FormTest extends UiTestCase
{
    public function test_it_renders()
    {
        UI::test('form', [
            'stream' => 'films',
        ])
            ->assertSee('<form')
            ->assertSee('name="title"');
    }

    public function test_it_supports_entries()
    {
        UI::test('form', [
            'stream' => 'films',
            'entry' => 4,
        ])->assertSee('A New Hope');
    }

    public function test_it_configures_from_streams()
    {
        UI::test('form', [
            'stream' => 'films',
        ])->assertSee('Foo Bar');

        Streams::extend('films', [
            'ui' => [
                'components' => [
                    [
                        'handle' => 'default',
                        'component' => 'form',
                        'fields' => [
                            [
                                'label' => 'Foo Bar',
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        Component::resetMemory();

        UI::test('form', [
            'stream' => 'films',
        ])->assertSee('Foo Bar');
    }
}
