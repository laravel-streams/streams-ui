<!-- content.blade.php -->
<div class="o-cp__content">
    @if (isset($slot))
        {!! $slot !!}
    @else
        @yield('content')
    @endif
</div>
