@if ($image->isVisible())
    @php
        $url = $image->getUrl();

        $imageAttributes = $image->getHtmlAttributeBag()->merge([
            'src' => $image->getSrc(),
            'alt' => $image->getAlt(),
        ]);

        if ($image->isLazy()) {
            $imageAttributes = $imageAttributes->merge(['loading' => 'lazy']);
        }
    @endphp

    @if ($url)
        <a
            href="{{ $url }}"
            @if ($image->shouldOpenInNewTab()) target="_blank" rel="noopener noreferrer" @endif
            {!! $image->getWrapperHtmlAttributeBag()->merge([
                'aria-label' => $image->getLinkAriaLabel() ?? $image->getAlt(),
            ]) !!}
        >
            <img {!! $imageAttributes !!} />
        </a>
    @else
        <img {!! $imageAttributes !!} />
    @endif
@endif
