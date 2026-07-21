<?php

namespace Streams\Ui\Tests\Builders\Inputs;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Inputs\Input;
use Streams\Ui\Builders\Inputs\TextInput;
use Streams\Ui\Builders\Inputs\SlugInput;

class SlugInputTest extends UiTestCase
{
    /** @test */
    public function it_extends_text_input(): void
    {
        $input = SlugInput::make('slug');

        $this->assertInstanceOf(Input::class, $input);
        $this->assertInstanceOf(TextInput::class, $input);
        $this->assertEquals('ui::builders.inputs.slug', $input->getView());
    }

    /** @test */
    public function it_configures_slugify_source_and_separator(): void
    {
        $input = SlugInput::make('slug')
            ->slugify('name')
            ->separator('_');

        $this->assertSame('name', $input->getSlugify());
        $this->assertSame('_', $input->getSeparator());
    }

    /** @test */
    public function it_resolves_slugify_state_path_from_sibling_handle(): void
    {
        $input = SlugInput::make('slug')->slugify('name');
        $input->statePath('data.finder-form.slug');

        $this->assertSame('data.finder-form.name', $input->getSlugifyStatePath());
    }

    /** @test */
    public function it_syncs_slugify_only_when_slug_is_blank(): void
    {
        $empty = SlugInput::make('slug')->slugify('name');
        $this->assertTrue($empty->shouldSyncSlugify());

        $withoutSlugify = SlugInput::make('slug');
        $this->assertFalse($withoutSlugify->shouldSyncSlugify());
    }

    /** @test */
    public function it_renders_with_livewire_entangle_binding(): void
    {
        $this->app['view']->share('errors', new \Illuminate\Support\ViewErrorBag);

        $html = SlugInput::make('slug')
            ->slugify('name')
            ->livewire(new class extends \Livewire\Component
            {
                public array $data = ['slug' => 'kids-ministry', 'name' => 'Kids Ministry'];

                public function render()
                {
                    return '<div></div>';
                }
            })
            ->statePath('data.slug')
            ->toHtml();

        $this->assertStringContainsString("\$wire.entangle('data.slug')", $html);
        $this->assertStringContainsString('x-model="value"', $html);
        $this->assertStringNotContainsString('$wire.set(', $html);
    }
}
