<?php

namespace Streams\Ui\Form\Component\Field;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Core\Addon\FieldType\FieldType;
use Streams\Core\Stream\Contract\StreamInterface;
use Streams\Core\Addon\FieldType\FieldTypeBuilder;

/**
 * Class FieldFactory
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FieldFactory
{

    /**
     * The field type builder utility.
     *
     * @var FieldTypeBuilder
     */
    protected $builder;

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * Create a new FieldFactory instance.
     *
     * @param FieldTypeBuilder $builder
     * @param Request          $request
     */
    public function __construct(FieldTypeBuilder $builder, Request $request)
    {
        $this->builder  = $builder;
        $this->request  = $request;
    }

    /**
     * Make a field type.
     *
     * @param  array           $parameters
     * @param  StreamInterface $stream
     * @param  null            $entry
     * @return FieldType
     */
    public function make(array $parameters, StreamInterface $stream = null, $entry = null)
    {
        /* @var EntryInterface $entry */
        if ($stream && $entry->stream()->fields->has(Arr::get($parameters, 'field'))) {

            /*
             * Allow overriding the type here
             * should they want to do that.
             */
            if (Arr::get($parameters, 'type')) {
                $field = $this->builder->build($parameters);
            } else {
                $field = $entry->stream()->fields->get(Arr::get($parameters, 'field'))->type();
            }

            //$modifier = $field->getModifier();

            $value = Arr::pull($parameters, 'value');

            /* @var EntryInterface $entry */
            $field->setValue(
                $value
                //(!is_null($value)) ? $modifier->restore($value) : $value
            );
        } elseif (is_object($entry)) {
            $field    = $this->builder->build($parameters);

            $value = Arr::pull($parameters, 'value');

            $field->setValue((!is_null($value)) ? $value : $entry->{$field->getField()});
        } else {
            $field    = $this->builder->build($parameters);
            $field->setValue(Arr::pull($parameters, 'value'));
        }

        // Set the entry.
        $field->setEntry($entry);

        // Merge in rules and validators.
        $field
            ->mergeRules(Arr::pull($parameters, 'rules', []))
            ->mergeConfig(Arr::pull($parameters, 'config', []))
            ->mergeMessages(Arr::pull($parameters, 'messages', []))
            ->mergeValidators(Arr::pull($parameters, 'validators', []));

        // Add the form builder.
        $parameters['form'] = $this->builder;

        // Hydrate the field with parameters.
        Hydrator::hydrate($field, $parameters);

        return $field;
    }
}
