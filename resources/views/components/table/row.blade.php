<tr>
    @foreach ($component->columns as $column)
    @livewire('table.column', array_merge($column, [
        'entry' => $component->entry,
    ]))
    @endforeach
    <td>
        @foreach ($component->buttons as $button)
        @livewire('button', $button)
        @endforeach
    </td>
</tr>
