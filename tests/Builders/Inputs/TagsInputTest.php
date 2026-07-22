<?php

namespace Streams\Ui\Tests\Builders\Inputs;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Inputs\TagsInput;

class TagsInputTest extends UiTestCase
{
    /** @test */
    public function it_configures_placeholder_suggestions_and_split_keys(): void
    {
        $input = TagsInput::make('tags')
            ->placeholder('New tag...')
            ->suggestions(['Alpha', 'Beta'])
            ->splitKeys([',', 'Tab']);

        $this->assertSame('New tag...', $input->getPlaceholder());
        $this->assertSame(['Alpha', 'Beta'], $input->getSuggestions());
        $this->assertSame([',', 'Tab'], $input->getSplitKeys());
        $this->assertSame('ui::builders.inputs.tags', $input->getView());
    }
}
