<?php

namespace Streams\Ui\Tests\Support;

use Streams\Ui\Table\Row\Row;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Table\Action\Action;
use Streams\Core\Support\Facades\Streams;

class TableTest extends UiTestCase
{

    public function test_it_builds()
    {
        $table = Streams::make('films')->ui('table');

        $this->assertInstanceOf(Row::class, $table->rows->first());
    }

    public function test_it_posts()
    {
        $this->post('');

        $table = Streams::make('films')->ui('table');

        $table->addCallback('posted', function () {
            throw new \Exception('Posted');
        });

        $this->expectException(\Exception::class);

        $table->response();
    }

    public function test_it_detects_action_when_submitted()
    {
        $this->post('', [
            'action' => 'save',
        ]);

        $table = Streams::make('films')->ui('table', [
            'actions' => [
                [
                    'handle' => 'save',
                    'handler' => function () {
                        throw new \Exception('Handling');
                    }
                ]
            ]
        ]);

        $this->expectException(\Exception::class);

        $table->post();

        $this->assertInstanceOf(Action::class, $table->actions->active());
    }

    public function test_it_can_post_without_handling()
    {
        $this->post('', [
            'action' => 'save',
        ]);

        $table = Streams::make('films')->ui('table', [
            'actions' => [
                [
                    'handle' => 'save',
                ]
            ]
        ]);

        $table->post();

        $this->assertSame('save', $table->actions->active()->handle);
    }

    public function test_it_has_handler_authority()
    {
        $this->post('', [
            'action' => 'save',
        ]);

        $table = Streams::make('films')->ui('table', [
            'actions' => [
                [
                    'handle' => 'save',
                ],
                [
                    'handle' => 'delete',
                ]
            ]
        ]);

        $action = $table->actions->get('delete');

        $action->active = true;

        $table->post();

        $this->assertSame('delete', $table->actions->active()->handle);
    }
}
