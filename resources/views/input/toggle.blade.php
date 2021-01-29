<div x-data="{checked: {{ json_encode($input->value) }}}">

    <!-- This SWITCH example requires Tailwind CSS v2.0+ -->
    <!-- On: "bg-indigo-600", Off: "bg-gray-200" -->
    {{-- <button type="button" class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue" x-bind:class="{ 
        'bg-primary' : checked,
        'bg-gray' : !checked,
      }" x-on:click="checked == true ? checked = false : checked = true;">
        <span class="sr-only">Use setting</span>
        
        <span class="inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200" x-bind:class="{ 
            'translate-x-5' : checked,
            'translate-x-0' : !checked,
          }"></span>
    </button> --}}

    <input {!! $input->htmlAttributes([
        'class' => 'hidden',
        'value' => null,
        'checked' => ($input->value),
    ]) !!} x-model="checked">
    
</div>
