<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Component;
use Streams\Core\Support\Facades\Streams;

class TableTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('table', [
            'stream' => 'films',
        ])
            ->assertSeeHtml('<table')
            ->assertSee('4');
    }

    public function test_it_configures_from_streams()
    {
        Livewire::test('table', [
            'stream' => 'films',
        ])->assertDontSee('A New Hope');

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

        Livewire::test('table', [
            'stream' => 'films',
        ])->assertSee('A New Hope');
    }
}
