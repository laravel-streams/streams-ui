<?php

namespace Streams\Ui\Tests\Components;

use Livewire\Livewire;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Component;
use Streams\Core\Support\Facades\Streams;

class FormTest extends UiTestCase
{
    public function test_it_renders()
    {
        Livewire::test('form', [
            'stream' => 'films',
        ])
            ->assertSeeHtml('<form')
            ->assertSeeHtml('name="title"');
    }

    public function test_it_supports_entries()
    {
        Livewire::test('form', [
            'stream' => 'films',
            'entry' => 4,
        ])->assertSee('A New Hope');
    }

    public function test_it_configures_from_streams()
    {
        Livewire::test('form', [
            'stream' => 'films',
        ])->assertDontSee('Foo Bar');

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

        Livewire::test('form', [
            'stream' => 'films',
        ])->assertSee('Foo Bar');
    }
}
