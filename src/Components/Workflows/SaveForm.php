<?php

namespace Streams\Ui\Components\Workflows;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Streams\Ui\Components\Form;
use Streams\Core\Support\Workflow;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Streams\Core\Support\Facades\Messages;

class SaveForm extends Workflow
{
    public array $steps = [
        // 'load_stream_config' => self::class . '@loadStreamConfig',
        // 'set_defaults' => self::class . '@setDefaults',
        'save_form' => self::class . '@saveForm',
    ];

    public function saveForm(Form $component)
    {
        if (!$stream = $component->stream()) {
            throw new \Exception('No stream defined.');
        }
        
        $result = $stream->validator(
            $data = Arr::except(
                Request::post(),
                array_filter(array_keys($_POST), fn ($key) => substr($key, 0, 1) == '_')
            ),
            $component->entry
        );

        if (!$result->passes()) {
            
            $component->errors = $result->messages()->messages();

            return;
        }

        if ($component->entry) {
            $entry = $component->entry()->fill($data);
        } else {
            $entry = $stream->repository()->newInstance($data);
        }

        $entry->save();
    }
}
