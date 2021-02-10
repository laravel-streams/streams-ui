<?php

namespace Streams\Ui\Tests\Support;

use Tests\TestCase;
use Streams\Core\Security\Policy;
use Illuminate\Support\Facades\Gate;
use Streams\Core\Support\Facades\Streams;

class TableAuthorizerTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/ui/tests/examples.json'));
    }

    public function testAuthorize()
    {
        $stream = Streams::make('testing.examples');

        Gate::define('viewAny-example', [ExamplePolicy::class, 'viewAny']);

        $table = $stream->table([
            'policy' => 'viewAny-example',
        ])->build();

        $this->assertEquals(true, $table->isSelectable());
    }
}

class ExamplePolicy extends Policy
{
 
    /**
     * Determine whether the user can view any anomaly users module user user models.
     *
     * @param $user
     * @param $model
     * @return mixed
     */
    public function viewAny($user, $model)
    {dd('Test!');
        return true;
    }
}
