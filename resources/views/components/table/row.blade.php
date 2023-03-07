<tr>
    
    @if ($component->selectable)
    <td><input type="checkbox"></td>
    @endif

    @foreach ($component->columns as $column)
    @ui('table.column', array_merge($column, [
        'entry' => $component->entry,
    ]))
    @endforeach

    @if ($component->buttons)
    <td>
        <div class="table__buttons">
            @foreach ($component->buttons as $button)
            @ui(Arr::pull($button, 'button', 'button'), $button)
            @endforeach
        </div>
    </td>
    @endif
    
</tr>
