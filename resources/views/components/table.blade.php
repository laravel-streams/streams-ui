<div>
    <table {!! $component->htmlAttributes([
        //'action' => $component->action,
        //'method' => $component->method,
        //'enctype' => $component->enctype,
    ]) !!}>

        @if (isset($slot))
            {!! $slot !!}
        @else
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Stream</th>
                    <th>JSON</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($component->entries as $entry)
                <tr>
                    <td>{{ $entry->id }}</td>
                    <td>{{ $entry->stream->id }}</td>
                    <td>{{ $entry->toJson() }}</td>
                </tr>    
                @endforeach
            </thead>
        @endif
    </table>    
</div>
