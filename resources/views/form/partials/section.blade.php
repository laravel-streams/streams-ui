<div {{ html_attributes(\Illuminate\Support\Arr::get($section, 'attributes', [])) }} class="form__section">

    @include('ui::form/partials/header')

    @include('ui::form/partials/fields', ['fields' => $section['fields']])

</div>
