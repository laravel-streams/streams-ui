<input type="datetime-local" name="{{ $input->field->handle }}"
value="{{ $input->field->value ? $input->field->value->format('Y-m-d\TH:i') : null }}" class="{{ implode(' ', $input->classes) }}" />
