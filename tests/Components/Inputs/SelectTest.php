<?php

namespace Streams\Ui\Tests\Components;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Components\Inputs\Select;
use Streams\Core\Support\Facades\Streams;

class SelectTest extends UiTestCase
{
    public function test_it_builds()
    {
        $this->assertInstanceOf(Select::class, UI::make('select'));
    }

    public function test_it_renders()
    {
        $output = UI::make('select', [
            'name' => 'test',
        ])->render();

        $this->assertStringContainsString('<select', $output);
    }

    public function test_it_returns_options()
    {
        $output = UI::make('select', [
            'name' => 'test',
            'options' => [
                'one' => 'One',
                'two' => 'Two',
            ],
        ])->render();

        $this->assertStringContainsString('value="one">One</option>', $output);
        $this->assertStringContainsString('value="two">Two</option>', $output);
    }

    public function test_it_supports_field_config()
    {
        $input = Streams::make('people')->fields->gender->input();

        $output = $input->render();

        $this->assertStringContainsString('value="male">Male</option>', $output);
        $this->assertStringContainsString('value="female">Female</option>', $output);
    }
}
