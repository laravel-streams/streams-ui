<div>
  <input {!! Html::attributes(
      array_filter([
          'id' => $component->id,
          'name' => $component->name,
          'type' => $component->type,
          'value' => $component->value,
          'pattern' => $component->pattern,
          'required' => $component->required,
          'readonly' => $component->readonly,
          'disabled' => $component->disabled,
      ])
  ) !!}>
</div>
