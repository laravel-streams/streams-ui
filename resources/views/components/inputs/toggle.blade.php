<div class="flex">

    <style>
        input:checked ~ .block {
            background-color: #48bb78;
        }
        
        input:checked ~ .dot {
            transform: translateX(100%);
        }
    </style>
  
    <label for="{{ $this->id }}" class="flex items-center cursor-pointer">
      
        <div class="relative">
        
            <input {!! $this->htmlAttributes([
                'value' => true,
                'type' => 'checkbox',
                'id' => $this->id,
                'name' => $this->name,
                'required' => $this->required,
                'readonly' => $this->readonly,
                'disabled' => $this->disabled,
                'checked' => $this->value == true,
                'class' => 'sr-only',
            ]) !!}>
        
            <div class="block bg-gray-600 w-14 h-8 rounded-full"></div>
        
            <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition"></div>
        </div>
      
        <div class="ml-3 text-gray-700 font-medium">
            {{ __($this->label) }}
        </div>
    </label>
  
  </div>
