<?php

namespace Streams\Ui\Components\Workflows;

use Illuminate\Support\Arr;
use Streams\Ui\Components\Form;
use Streams\Core\Support\Workflow;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Streams\Core\Validation\StreamsPresenceVerifier;

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

        $data = Arr::except(
            Request::post(),
            array_filter(array_keys($_POST), fn ($key) => substr($key, 0, 1) == '_')
        );

        $rules = $stream->rules([], $component->entry);

        $rules = Arr::only(
            $rules,
            array_keys($data)
        );

        Validator::setPresenceVerifier(new StreamsPresenceVerifier(App::make('db')));

        $result = Validator::make($data, $rules);

        file_put_contents(
            base_path('testing.json'),
            json_encode([
                'data' => $data,
                'rules' => $rules,
                'stream' => $stream->config,
                'messages' => $result->messages()->messages(),
            ], JSON_PRETTY_PRINT)
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
