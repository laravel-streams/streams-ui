<?php

namespace Streams\Ui\Tests\Builders\Prompts;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Actions\Action;
use Streams\Ui\Builders\Prompts\Prompt;

class PromptTest extends UiTestCase
{
    /** @test */
    public function it_has_left_aligned_md_defaults(): void
    {
        $prompt = TestPrompt::make();

        $this->assertSame('left', $prompt->getAlign());
        $this->assertSame('md', $prompt->getSize());
        $this->assertFalse($prompt->isMuted());
    }

    /** @test */
    public function it_can_set_text_via_has_text(): void
    {
        $prompt = TestPrompt::make()->text('Need help?');

        $this->assertSame('Need help?', $prompt->getText());
    }

    /** @test */
    public function it_evaluates_closure_text(): void
    {
        $prompt = TestPrompt::make()->text(fn () => sprintf('Hello %s', 'world'));

        $this->assertSame('Hello world', $prompt->getText());
    }

    /** @test */
    public function action_appends_to_actions_list(): void
    {
        $first = Action::make('first')->label('First');
        $second = Action::make('second')->label('Second');

        $prompt = TestPrompt::make()
            ->action($first)
            ->action($second);

        $actions = $prompt->getActions();

        $this->assertCount(2, $actions);
        $this->assertSame($first, $actions[0]);
        $this->assertSame($second, $actions[1]);
    }

    /** @test */
    public function it_can_configure_alignment_size_and_muted_state(): void
    {
        $prompt = TestPrompt::make()
            ->align('center')
            ->size('sm')
            ->muted();

        $this->assertSame('center', $prompt->getAlign());
        $this->assertSame('sm', $prompt->getSize());
        $this->assertTrue($prompt->isMuted());
    }
}

class TestPrompt extends Prompt
{
    protected string $view = 'ui::test-view';

    protected string $viewIdentifier = 'prompt';
}
