<tr>
    <td><input type="checkbox"></td>
    @foreach ($component->columns as $column)
    @livewire('table.column', array_merge($column, [
        'entry' => $component->entry,
    ]))
    @endforeach
    <td>
        <div class="flex">
            @foreach ($component->buttons as $button)
            @livewire('button', $button)
            @endforeach
        </div>
    </td>
</tr>
