<div>
    <form {!! $component->htmlAttributes([
        'action' => $component->action,
        'method' => $component->method,
        'enctype' => $component->enctype,
    ]) !!}>

        <input type="hidden" name="_id" value="{{ $component->id }}"/>
        
        {{ csrf_field() }}
    
        @if (isset($slot))
            {!! $slot !!}
        @else
            @foreach ($component->fields as $field)
                @livewire('field', $field)
            @endforeach
            
            @if ($component->buttons)
            <div class="mt-4">
                @foreach ($component->buttons as $button)
                    @livewire('button', $button)
                @endforeach
            </div>
            @endif
        @endif
    </form>    
</div>
