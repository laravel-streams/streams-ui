<?php

namespace Streams\Ui\Tests\Resources;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Resources\Resource;

class ResourceTabsTest extends UiTestCase
{
    /** @test */
    public function it_exposes_declarative_tabs(): void
    {
        $resource = new class extends Resource
        {
            protected static array $tabs = ['index' => 'All', 'edit' => 'Edit'];
        };

        $this->assertSame(['index' => 'All', 'edit' => 'Edit'], $resource::tabs());
    }
}
