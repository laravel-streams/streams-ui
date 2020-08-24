<div class="field__container">

    <label>{{ $field->label ?: $field->handle }}</label>

    <div class="field__input">
        <?php // @todo Replace this with $field->input(); // __toString() == $input->render() ?>
        @include('ui::input/' . ($field->input ?: 'input'), ['input' => $field])
    </div>

</div>
