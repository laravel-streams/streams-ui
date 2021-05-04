<?php

namespace Streams\Ui\Form;

use Streams\Ui\Form\Form;
use Illuminate\Support\Arr;
use Streams\Core\Field\Field;
use Streams\Ui\Button\Button;
use Streams\Core\Stream\Stream;
use Streams\Ui\Support\Builder;
use Streams\Ui\Form\Action\Action;
use Streams\Ui\Support\Normalizer;
use Illuminate\Support\Facades\App;
use Streams\Ui\Form\FormAuthorizer;
use Streams\Core\Repository\Repository;
use Streams\Ui\Button\ButtonCollection;
use Streams\Core\Support\Facades\Resolver;
use Streams\Core\Support\Facades\Evaluator;
use Streams\Ui\Form\Action\ActionCollection;

class FormBuilder extends Builder
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeAttributes(array $attributes)
    {
        return parent::initializePrototypeAttributes(array_merge([
            'async' => false,
            'handler' => null,
            'read_only' => false,

            'stream' => null,
            'repository' => null,

            'entry' => null,

            'rules' => [],
            'validators' => [],

            'fields' => [],
            'assets' => [],
            'actions' => [],
            'buttons' => [],
            'sections' => [],

            'config' => [
                'auto_query' => true,
            ],

            'component' => 'form',
            'form' => Form::class,

            'steps' => [
                'make_form' => [$this, 'make'],
                'setup' => [$this, 'setup'],

                'query_entry' => [$this, 'queryEntry'],

                'authorize_form' => [$this, 'authorizeForm'],

                'set_validation' => [$this, 'setValidation'],

                'make_fields' => [$this, 'makeFields'],
                'make_actions' => [$this, 'makeActions'],
                'make_buttons' => [$this, 'makeButtons'],
            ],
        ], $attributes));
    }

}
