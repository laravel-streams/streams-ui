<input type="datetime-local" name="{{ $input->field->handle }}"
value="{{ $input->field->value->format('Y-m-d\TH:i') }}" class="{{ implode(' ', $input->classes) }}" />
