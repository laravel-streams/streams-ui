<!-- field.blade.php -->
<<<<<<< HEAD
<div class="ls-field --{{ $field->type }}-field">

    <label>
        {{ __($field->input()->label()) }}

        @if ($field->isRequired())
            <span>*</span>
        @endif
    </label>
    
    <div class="ls-input --{{ $field->input['type'] }}-input">
        {!! $field->input()->render() !!}
=======
{{--
WIP: Not sure about this one. But it would allow a space-saving way on larger desktops
to have the label on the left side of the field.

If we decide it could be a good idea, we would abstract it and it would be a setting
and controlled through a master css class instead of the utility classes on these
wrappers and elements.

Probably would not work great on smaller screens when people wanna place fields
in two or more columns next to each other. But again, it could be controlled.
--}}

<div class="col-span-{{ $field->width ?: 12 }} {{ $field->type }}-field">

    <div class="flex flex-wrap xxxl:flex-no-wrap">
        <label class="font-bold leading-loose text-black dark:text-white
        xxxl:leading-normal w-full xxxl:max-w-xs xxxl:mr-4 xxxl:px-2 xxxl:py-2 ">
            {{ __($field->input()->label()) }}
        </label>
        <div class="w-full">
            {!! $field->input()->render() !!}
        </div>
>>>>>>> feature/webpack-mix-root-based-bundling
    </div>

</div>
