<div class="flex">

    <style>
        input:checked ~ .block {
            background-color: #48bb78;
        }
        
        input:checked ~ .dot {
            transform: translateX(100%);
        }
    </style>
  
    <label for="{{ $component->id }}" class="flex items-center cursor-pointer">
      
        <div class="relative">
        
            <input {!! $component->htmlAttributes([
                'value' => true,
                'type' => 'checkbox',
                'id' => $component->id,
                'name' => $component->name,
                'required' => $component->required,
                'readonly' => $component->readonly,
                'disabled' => $component->disabled,
                'checked' => $component->value == true,
                'class' => 'sr-only',
            ]) !!}>
        
            <div class="block bg-gray-600 w-14 h-8 rounded-full"></div>
        
            <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition"></div>
        </div>
      
        <div class="ml-3 text-gray-700 font-medium">
            {{ __($component->label) }}
        </div>
    </label>
  
  </div>
