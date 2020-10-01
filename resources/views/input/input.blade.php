<input type="{{ Arr::get($input->config, 'type') ?: 'text' }}" name="{{ $input->field->handle }}" value="{{ $input->field->value }}" class="{{ implode(' ', $input->classes) }}">
