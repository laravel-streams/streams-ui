<!-- fields.blade.php -->
<div class="grid grid-cols-12 gap-4">
@foreach ($fields as $field)
@include('ui::forms.field', ['field' => $field])
@endforeach
</div>
