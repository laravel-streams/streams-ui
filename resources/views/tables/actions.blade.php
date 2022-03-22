<!-- actions.blade.php -->
<div class="c-table__actions">
    {!! $table->actions->pluck('render')->implode('') !!}
</div>
