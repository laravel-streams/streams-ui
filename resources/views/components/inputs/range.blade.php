<div>
  <input {!! Html::attributes(
      array_filter([
          'id' => $component->id,
          'max' => $component->max,
          'min' => $component->min,
          'name' => $component->name,
          'step' => $component->step,
          'type' => $component->type,
          'value' => $component->value,
          'required' => $component->required,
          'readonly' => $component->readonly,
          'disabled' => $component->disabled,
      ])
  ) !!}>
</div>
