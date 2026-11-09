<?php

namespace Streams\Ui\Tests\Builders;

use Symfony\Component\Process\Process;
use Streams\Ui\Widgets\LogTail;
use Streams\Ui\Tests\UiTestCase;

class LogTailTest extends UiTestCase
{
    /** @test */
    public function it_keeps_only_the_last_cap_lines(): void
    {
        $tail = LogTail::make('t')->cap(3)->source(fn () => ['a', 'b', 'c', 'd', 'e']);

        $this->assertSame(['c', 'd', 'e'], $tail->getLines());
        $this->assertSame(2, $tail->getOffset());
    }

    /** @test */
    public function it_renders_lines_and_config(): void
    {
        $html = LogTail::make('t')->cap(2)->source(fn () => ['one', 'two', 'three'])
            ->refreshOn('run.1', 'line')->toHtml();

        $this->assertStringContainsString('three', $html);
        $this->assertStringNotContainsString('>one<', $html);
        $this->assertStringContainsString('data-cap="2"', $html);
        $this->assertStringContainsString('data-refresh-on', $html);
    }

    /** @test */
    public function it_appends_without_re_rendering_old_lines_and_respects_cap(): void
    {
        $js = dirname(__DIR__, 2).'/resources/js/log-tail.js';

        $script = <<<JS
        globalThis.window = globalThis;
        require('{$js}');
        const mk = () => { const n = {children: [], get firstChild() { return this.children[0]; }, get childNodes() { return this.children; },
            appendChild(c) { this.children.push(c); }, removeChild(c) { this.children.splice(this.children.indexOf(c), 1); },
            ownerDocument: {createElement: () => ({})}, scrollTop: 0, scrollHeight: 10}; return n; };
        const view = mk();
        const attrs = {'data-lines': '["a","b","c"]', 'data-offset': '0', 'data-cap': '3'};
        const el = {getAttribute: (k) => attrs[k]};
        const state = {next: 0, pinned: true};
        window.streamsLogTail.sync(el, view, state);
        const first = view.children[0];
        attrs['data-lines'] = '["b","c","d","e"]'; attrs['data-offset'] = '1';
        window.streamsLogTail.sync(el, view, state);
        console.log(JSON.stringify({
            texts: view.children.map(c => c.textContent),
            firstDropped: view.children.indexOf(first) === -1,
            len: view.children.length,
        }));
        JS;

        $process = new Process(['node', '-e', $script]);
        $process->mustRun();
        $result = json_decode($process->getOutput(), true);

        $this->assertSame(['c', 'd', 'e'], $result['texts']);
        $this->assertTrue($result['firstDropped']);
        $this->assertSame(3, $result['len']);
    }
}
