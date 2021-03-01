<!-- top.blade.php -->
<div class="o-cp__topbar">
    <div class="c-topbar">
        
        <div class="c-topbar__buttons" x-data="{}">
            {!! $cp->buttons !!}
        </div>

        @include('ui::cp.shortcuts')

    </div>
</div>
