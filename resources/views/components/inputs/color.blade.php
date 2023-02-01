<div>
  <input {!! Html::attributes(
      array_filter([
          'type' => 'color',
          'id' => $component->id,
          'name' => $component->name,
          'value' => $component->value,
          'pattern' => $component->pattern,
          'required' => $component->required,
          'readonly' => $component->readonly,
          'disabled' => $component->disabled,
      ])
  ) !!}>
</div>
