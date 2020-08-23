<?php

namespace Anomaly\Streams\Ui\Form\Component\Field\Workflows\Fields;

use Illuminate\Support\Arr;
use Anomaly\Streams\Ui\Form\FormBuilder;
use Anomaly\Streams\Ui\Support\Normalizer;

/**
 * Class NormalizeFields
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NormalizeFields
{

    /**
     * Handle the step.
     *
     * @param FormBuilder $builder
     */
    public function handle(FormBuilder $builder)
    {
        $fields = $builder->fields;

        foreach ($fields as $handle => &$field) {

            /*
             * If the field is a wild card marker
             * then just continue.
             */
            if ($field == '*') {
                continue;
            }

            /*
             * If the handle is numeric and the field
             * is a string then use the field as is.
             */
            if (is_numeric($handle) && is_string($field)) {
                $field = [
                    'field' => $field,
                ];
            }

            /*
             * If the handle is a string and the field
             * is a string too then use the field as the
             * type and the field as well.
             */
            if (!is_numeric($handle) && is_string($handle) && is_string($field)) {
                $field = [
                    'field' => $handle,
                    'type'  => $field,
                ];
            }

            /*
             * Tuck the field away since it represents
             * an attribute as well as the component
             * handle/name and type like the others.
             */
            if (is_array($field) && !isset($field['stream_field'])) {
                $field['stream_field'] = $handle;
            }
        }

        $fields = Normalizer::attributes($fields);

        $builder->fields = $fields;
    }
}
