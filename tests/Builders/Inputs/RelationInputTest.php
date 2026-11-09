<?php

namespace Streams\Ui\Tests\Builders\Inputs;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Inputs\RelationInput;

class RelationInputTest extends UiTestCase
{
    protected function people(): \Closure
    {
        $rows = [
            ['id' => 1, 'name' => 'Alice'],
            ['id' => 2, 'name' => 'Alan'],
            ['id' => 3, 'name' => 'Bob'],
        ];

        return fn (string $term) => array_filter(
            $rows,
            fn ($r) => $term === '' || stripos($r['name'], $term) !== false,
        );
    }

    /** @test */
    public function it_configures_and_searches(): void
    {
        $input = RelationInput::make('person_id')
            ->query($this->people())
            ->display('name')
            ->searchable();

        $this->assertSame('ui::builders.inputs.relation', $input->getView());
        $this->assertTrue($input->isSearchable());
        $this->assertFalse($input->isMultiple());
        $this->assertSame(
            [['value' => 1, 'label' => 'Alice'], ['value' => 2, 'label' => 'Alan']],
            $input->search('al'),
        );
    }

    /** @test */
    public function it_supports_multiple_display_closures_and_limit(): void
    {
        $input = RelationInput::make('people')
            ->query($this->people())
            ->multiple()
            ->display(fn ($r) => strtoupper($r['name']))
            ->limit(2);

        $this->assertTrue($input->isMultiple());
        $this->assertSame('ALICE', $input->search('')[0]['label']);
        $this->assertCount(2, $input->search(''));
    }

    /** @test */
    public function create_using_returns_the_new_option(): void
    {
        $input = RelationInput::make('person_id')
            ->display('name')
            ->createUsing(fn (string $text) => ['id' => 9, 'name' => $text]);

        $this->assertTrue($input->canCreate());
        $this->assertSame(['value' => 9, 'label' => 'Zed'], $input->create('Zed'));
        $this->assertNull(RelationInput::make('x')->create('Zed'));
    }

    /** @test */
    public function it_registers_for_the_page_trait_and_ships_its_view(): void
    {
        $input = RelationInput::make('person_id')->register();

        $this->assertSame($input, RelationInput::registered($input->getStatePath()));
        $this->assertFileExists(dirname(__DIR__, 3).'/resources/views/builders/inputs/relation.blade.php');
    }
}
