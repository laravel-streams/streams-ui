<!-- field.blade.php -->
{{--  
WIP: Not sure about this one. But it would allow a space-saving way on larger desktops
to have the label on the left side of the field.    

If we decide it could be a good idea, we would abstract it and it would be a setting 
and controlled through a master css class instead of the utility classes on these 
wrappers and elements.

Probably would not work great on smaller screens when people wanna place fields 
in two or more columns next to each other. But again, it could be controlled.
--}}
<div {!! $field->htmlAttributes() !!}>
    
    <div class="grid grid-cols-12 gap-4">
        <label class="xs:col-span-12 md:col-span-12 lg:col-span-12 xl:col-span-12 xxl:col-span-3">{{ $field->label ?: $field->handle }}</label>
        <div class="xs:col-span-12 md:col-span-12 lg:col-span-12 xl:col-span-12 xxl:col-span-9">
            {!! $field->input() !!}
        </div>

    </div>


</div>
