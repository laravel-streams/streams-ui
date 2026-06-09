<?php

namespace Streams\Ui\Builders\Prompts;

final class InlinePrompt extends Prompt
{
    protected string $viewIdentifier = 'prompt';

    protected string $view = 'ui::builders.inline-prompt';
}
