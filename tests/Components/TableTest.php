<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Component;
use Streams\Ui\Support\Facades\UI;
use Streams\Core\Support\Facades\Streams;

class TableTest extends UiTestCase
{
    public function test_it_renders()
    {
        UI::test('table', [
            'stream' => 'films',
        ])
            ->assertSee('<table')
            ->assertSee('4');
    }

    public function test_it_configures_from_streams()
    {
        UI::test('table', [
            'stream' => 'films',
        ])->assertNotSee('A New Hope');

        Streams::extend('films', [
            'ui' => [
                'components' => [
                    [
                        'handle' => 'default',
                        'component' => 'table',
                        'columns' => [
                            [
                                'value' => 'title',
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        Component::resetMemory();

        UI::test('table', [
            'stream' => 'films',
        ])->assertSee('A New Hope');
    }
}
