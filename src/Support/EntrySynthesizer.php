<?php

namespace Streams\UI\Support;

use Illuminate\Support\Arr;
use Streams\Core\Entry\Entry;
use Streams\Core\Support\Facades\Streams;
use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;

class EntrySynthesizer extends Synth
{
    public static $key = 'entry';

    public static function match($target)
    {
        return $target instanceof Entry;
    }

    public function dehydrate(Entry $target)
    {
        $data = $target->toArray();
        
        $data['__STREAM__'] = $target->stream()->id;

        return [$data, []];
    }

    public function hydrate($value)
    {
        $stream = Arr::pull($value, '__STREAM__', Entry::class);

        return Streams::entries($stream)->newInstance($value);
    }
}
