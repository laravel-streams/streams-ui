<?php

namespace Anomaly\Streams\Ui\Form;

use Collective\Html\FormFacade;
use Illuminate\Support\Collection;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Request;
use Anomaly\Streams\Ui\Support\Component;
use Anomaly\Streams\Ui\Button\ButtonCollection;
use Anomaly\Streams\Ui\Form\Component\Field\FieldCollection;
use Anomaly\Streams\Ui\Form\Component\Action\ActionCollection;
use Anomaly\Streams\Ui\Form\Component\Section\SectionCollection;

/**
 * Class Form
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Form extends Component
{

    /**
     * Create a new class instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct(array_merge([
            'mode' => null,
            'entry' => null,
            'component' => 'form',

            'values' => new Collection(),
            'options' => new Collection(),

            'rules' => new Collection(),
            'validators' => new Collection(),

            'errors' => new MessageBag(),

            'fields' => new FieldCollection(),
            'actions' => new ActionCollection(),
            'buttons' => new ButtonCollection(),
            'sections' => new SectionCollection(),
        ], $attributes));
    }

    protected $properties = [
        'values' => [
            'type' => 'collection',
        ],
        'options' => [
            'type' => 'collection',
        ],

        'rules' => [
            'type' => 'collection',
        ],
        'validators' => [
            'type' => 'collection',
        ],

        'errors' => [
            'type' => 'collection',
            'config' => [
                'abstract' => MessageBag::class,
            ],
        ],

        'fields' => [
            'type' => 'collection',
            'config' => [
                'abstract' => FieldCollection::class,
            ],
        ],
        'actions' => [
            'type' => 'collection',
            'config' => [
                'abstract' => ActionCollection::class,
            ],
        ],
        'buttons' => [
            'type' => 'collection',
            'config' => [
                'abstract' => ButtonCollection::class,
            ],
        ],
        'sections' => [
            'type' => 'collection',
            'config' => [
                'abstract' => SectionCollection::class,
            ],
        ],
    ];

    /**
     * Return the opening form tag.
     *
     * @param  array $options
     * @return string
     */
    public function open(array $options = [])
    {
        if ($url = $this->options->get('url')) {
            $options['url'] = $url;
        } else {
            $options['url'] = Request::fullUrl();
        }

        // For good measure?
        // @todo is this a security risk?
        $options['enctype'] = 'multipart/form-data';

        if ($this->options->get('ajax') === true) {
            $options['data-async'] = 'true';
        }

        return FormFacade::open($options);
    }

    /**
     * Return the closing form tag.
     *
     * @return string
     */
    public function close()
    {
        return FormFacade::close();
    }
}
