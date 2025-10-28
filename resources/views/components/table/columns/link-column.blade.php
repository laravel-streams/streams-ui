<a href="{{ $column->getUrl() }}" {{ $attributes->class(['font-semibold underline'])->merge($column->getHtmlAttributes()) }}>{!! $column->getValue() !!}
</a>
