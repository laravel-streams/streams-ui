<!-- meta.blade.php -->
<small class="c-table__meta">
    {{ $table->options->get('total_results') }} {{ trans_choice('ui::labels.results', $table->options->get('total_results')) }}
</small>
