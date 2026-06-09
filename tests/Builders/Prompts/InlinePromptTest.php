<?php

namespace Streams\Ui\Tests\Builders\Prompts;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Actions\Action;
use Streams\Ui\Builders\Prompts\InlinePrompt;

class InlinePromptTest extends UiTestCase
{
    /** @test */
    public function it_can_be_made_and_renders_text_with_action(): void
    {
        $html = InlinePrompt::make()
            ->text('Don\'t have an account?')
            ->action(
                Action::make('register')
                    ->label('Register here.')
                    ->link()
                    ->tag('a')
                    ->url('/register')
            )
            ->toHtml();

        $this->assertStringContainsString('have an account?', $html);
        $this->assertStringContainsString('Register here.', $html);
        $this->assertStringContainsString('href="/register"', $html);
    }

    /** @test */
    public function it_renders_center_aligned_action_only_prompt_without_text_span(): void
    {
        $html = InlinePrompt::make()
            ->align('center')
            ->action(
                Action::make('forgot')
                    ->label('Forgot your password?')
                    ->link()
                    ->tag('a')
                    ->url('/forgot-password')
            )
            ->toHtml();

        $this->assertStringContainsString('Forgot your password?', $html);
        $this->assertStringContainsString('justify-center', $html);
        $this->assertStringNotContainsString('<span>Don\'t have an account?</span>', $html);
    }

    /** @test */
    public function it_renders_muted_text_style(): void
    {
        $html = InlinePrompt::make()
            ->text('Need help?')
            ->muted()
            ->action(
                Action::make('support')
                    ->label('Contact support.')
                    ->link()
                    ->tag('a')
                    ->url('/support')
            )
            ->toHtml();

        $this->assertStringContainsString('text-gray-500', $html);
        $this->assertStringContainsString('Need help?', $html);
    }

    /** @test */
    public function it_renders_multiple_actions_with_and_separator(): void
    {
        $html = InlinePrompt::make()
            ->text('By continuing, you agree to our')
            ->actions([
                Action::make('terms')->label('Terms')->link()->tag('a')->url('/terms'),
                Action::make('privacy')->label('Privacy Policy')->link()->tag('a')->url('/privacy'),
            ])
            ->toHtml();

        $this->assertStringContainsString('By continuing, you agree to our', $html);
        $this->assertStringContainsString('Terms', $html);
        $this->assertStringContainsString('Privacy Policy', $html);
        $this->assertStringContainsString('and', $html);
    }
}
