<!-- fields.blade.php -->
<div class="grid gap-4 grid-cols-12">
@foreach ($fields as $field)
@include('ui::forms.field', ['field' => $field])
@endforeach
</div>
