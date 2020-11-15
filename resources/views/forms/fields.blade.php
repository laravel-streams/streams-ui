<div class="flex flex-wrap">
@foreach ($fields as $field)
@include('ui::forms.field', ['field' => $field])
@endforeach
</div>
