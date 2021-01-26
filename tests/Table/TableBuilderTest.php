<?php

namespace Streams\Ui\Tests\Support;

use Tests\TestCase;
use Streams\Ui\Table\Table;
use Illuminate\Support\Collection;
use Streams\Ui\Table\TableBuilder;
use Illuminate\Support\Facades\URL;
use Streams\Core\Repository\Repository;
use Streams\Core\Support\Facades\Streams;

class TableBuilderTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/examples.json'));
    }

    public function testRepository()
    {
        $stream = Streams::make('testing.examples');

        $this->assertInstanceOf(TableBuilder::class, $builder = $stream->table());

        $this->assertInstanceOf(Repository::class, $builder->repository());
        $this->assertInstanceOf(Repository::class, $builder->repository());

        $builder->repository = OverrideRepository::class;

        $this->assertInstanceOf(OverrideRepository::class, $builder->repository());
    }

    public function testBuild()
    {
        $stream = Streams::make('testing.examples');

        $builder = $stream->table();

        $this->assertInstanceOf(Table::class, $builder->build());
    }
}

class OverrideRepository extends Repository
{
    // Override
}
