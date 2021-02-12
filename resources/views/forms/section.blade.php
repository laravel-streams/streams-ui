<!-- section.blade.php -->
<div class="c-card">

    @include('ui::forms.header')

    @include('ui::forms.fields', ['fields' => $section['fields']])

</div>
