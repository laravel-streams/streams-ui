<?php

namespace Streams\Ui\Form;

use Collective\Html\FormFacade;
use Illuminate\Support\Collection;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Request;
use Streams\Ui\Form\FormHandler;
use Streams\Ui\Support\Component;
use Streams\Ui\Button\ButtonCollection;
use Streams\Ui\Form\Component\Field\FieldCollection;
use Streams\Ui\Form\Component\Action\ActionCollection;
use Streams\Ui\Form\Component\Section\SectionCollection;

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
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototype(array $attributes)
    {
        $this->loadPrototypeProperties([
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
        ]);
        
        return parent::initializePrototype(array_merge([
            'component' => 'form',
            'template' => 'ui::forms.form',

            'mode' => null,
            'entry' => null,
            
            'handler' => FormHandler::class,

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

        $options['files'] = true; // multipart/form-data

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
