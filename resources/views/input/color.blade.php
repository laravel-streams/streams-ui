<!-- color.blade.php -->
<input {!! $input->htmlAttributes([
    'type' => 'color',
]) !!} {{-- oninput="document.documentElement.style.setProperty('--color-primary', this.value);" --}}>
