<tr>
    
    @if ($component->selectable)
    <td><input name="id[{{ $component->entry['id'] ?? null }}]" type="checkbox"></td>
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
            @ui(Arr::pull($button, 'button', 'button'), array_merge($button, [
                'parse_data' => ['entry' => $component->entry],
            ]))
            @endforeach
        </div>
    </td>
    @endif
    
</tr>
