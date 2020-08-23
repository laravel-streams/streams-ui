<div style="display: none;">
    <button type="button">
        {{ trans('ui::locale.' . $fieldType->getLocale() . '.name') }}
    </button>
    <div class="dropdown-menu">
        @foreach (config('ui::locales.enabled', []) as $iso)
            <button type="button" class="dropdown-item {{ $iso == config('ui::locales.default') ? 'active' : null }}"
               href="#"
               data-toggle="lang" lang="{{ $iso }}">
                {{ trans('ui::locale.' . $iso . '.name') }}
            </button>
        @endforeach
    </div>
</div>
