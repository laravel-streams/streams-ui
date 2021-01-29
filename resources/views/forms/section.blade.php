<!-- section.blade.php -->
<div class="ls-layout__section">

    @include('ui::forms.header')

    @include('ui::forms.fields', ['fields' => $section['fields']])

</div>
