@foreach ($layout->content ?: [] as $content)
    {!! $content->render() !!}
@endforeach
