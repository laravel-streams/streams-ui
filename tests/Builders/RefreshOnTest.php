<?php

namespace Streams\Ui\Tests\Builders;

use Livewire\Component;
use Symfony\Component\Process\Process;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Containers\Container;

class RefreshOnTest extends UiTestCase
{
    protected function makeTable()
    {
        $component = new class extends Component
        {
            use \Streams\Ui\Livewire\Tables\InteractsWithTable;
        };

        $component->bootedInteractsWithTable();

        return $component->getTable();
    }

    protected function runJs(string $script): array
    {
        $process = new Process(['node', '-e', $script]);
        $process->mustRun();

        return json_decode($process->getOutput(), true);
    }

    protected function harness(string $body): string
    {
        $js = dirname(__DIR__, 2).'/resources/js/refresh-on.js';

        return <<<JS
        const listeners = {};
        const out = {refreshes: 0, channel: null};
        const wire = {\$refresh: () => out.refreshes++};
        const make = (cfg) => ({getAttribute: () => JSON.stringify(cfg)});
        {$body}
        JS;
    }

    /** @test */
    public function container_without_refresh_on_has_no_attributes(): void
    {
        $html = Container::make('c')->toHtml();

        $this->assertStringNotContainsString('data-refresh-on', $html);
    }

    /** @test */
    public function container_renders_refresh_on_config(): void
    {
        $html = Container::make('c')->refreshOn('work', 'work.changed', 3)->toHtml();

        $this->assertStringContainsString('data-refresh-on', $html);
        $this->assertStringContainsString('streamsRefreshOn', $html);
        $this->assertStringContainsString('work.changed', $html);
        $this->assertStringContainsString('3000', $html);
    }

    /** @test */
    public function table_renders_refresh_on_config(): void
    {
        $table = $this->makeTable()->refreshOn('work', ['a', 'b'], 10, true);

        $this->assertSame('work', $table->getRefreshOn()['channel']);
        $this->assertSame(['a', 'b'], $table->getRefreshOn()['events']);
        $this->assertSame(10000, $table->getRefreshOn()['poll']);
        $this->assertArrayHasKey('data-refresh-on', $table->getRefreshOnAttributes());

        $this->assertStringContainsString('streamsRefreshOn', $table->getRefreshOnAttributes()['x-init']);
    }

    /** @test */
    public function table_refreshes_on_broadcast_with_fake_echo(): void
    {
        $js = dirname(__DIR__, 2).'/resources/js/refresh-on.js';

        $result = $this->runJs($this->harness(<<<JS
        globalThis.window = globalThis;
        window.Echo = {
            channel: (name) => ({listen: (event, cb) => { listeners[event] = cb; out.channel = name; return this; }}),
            leave: () => {},
        };
        require('{$js}');
        const handle = window.streamsRefreshOn.mount(make({channel: 'work', events: ['work.changed'], poll: 5000, private: false}), wire);
        listeners['work.changed']();
        out.mode = handle.mode;
        handle.destroy();
        console.log(JSON.stringify(out));
        JS));

        $this->assertSame('echo', $result['mode']);
        $this->assertSame('work', $result['channel']);
        $this->assertSame(1, $result['refreshes']);
    }

    /** @test */
    public function table_polls_without_echo(): void
    {
        $js = dirname(__DIR__, 2).'/resources/js/refresh-on.js';

        $result = $this->runJs($this->harness(<<<JS
        globalThis.window = globalThis;
        require('{$js}');
        const handle = window.streamsRefreshOn.mount(make({channel: 'work', events: ['x'], poll: 10, private: false}), wire);
        setTimeout(() => {
            handle.destroy();
            out.mode = handle.mode;
            console.log(JSON.stringify(out));
        }, 100);
        JS));

        $this->assertSame('poll', $result['mode']);
        $this->assertGreaterThanOrEqual(2, $result['refreshes']);
    }
}
