<div class="form__wrapper">
    <form {!! $this->htmlAttributes([
        //'action' => $this->action,
        //'method' => $this->method,
        'class' => 'form',
        'method' => 'post',
        'enctype' => 'multipart/form-data',
        //'wire:submit.prevent' => 'save',
    ]) !!}>

        <div class="form__fields">
            {{-- @foreach ($this->fields as $field)
            @ui('field', $field)
            @endforeach --}}
        </div>

        @if ($this->getButtons())
        <div class="mt-4 flex space-x-2">
            @foreach ($this->getButtons() as $button)
            @livewire($button)
            @endforeach
        </div>
        @endif

    </form>
</div>
