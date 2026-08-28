<div
    x-data="{ open: false }"
    class="relative inline-block"
    @keydown.window.escape="open = false"
    @click.away="open = false"
>
    
    <div @click="open = !open">
        <x-ui::action
            :tag="$action->getTag()"
            :href="$action->getUrl()"
            :icon="$action->getIcon()"
            :size="$action->getSize() ?? 'md'"
            :color="$action->getColor()"
            :style="$action->getStyle()"
            :tooltip="$action->getTooltip()"
            :disabled="$action->isDisabled()"
            :keyBindings="$action->getKeyBindings()"
            :borderRadius="$action->getBorderRadius()"
            target="{{ $action->shouldOpenInNewTab() ? '_blank' : '_self' }}"
            :attributes="$action->getHtmlAttributeBag()"
            :openInNewTab="$action->shouldOpenInNewTab()"
            :loadingIndicator="$action->getLoadingIndicator()"
            :labelSrOnly="$action->getLabel() ? false : true"
            >@if (filled($label = $action->getLabel())){{ $label }}@endif
        </x-ui::action>
    </div>

    <div x-show="open" 
         x-transition
         class="absolute right-0 mt-2 min-w-48 max-w-xs rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 overflow-hidden">
        <div class="py-1" role="menu">
            @foreach ($action->getActions() as $menuAction)
            
            @php
                // Prefer the full entry instance so nested closures can read attributes
                // (status, etc.). getEntry() returns only the id for EntryInterface.
                $menuAction->entry($action->getEntryInstance());
            @endphp

            @continue(! $menuAction->isVisible())

            @php
                $disabled = $menuAction->isDisabled();

                $href = $menuAction->getUrl();
                $tag = $menuAction->getTag() ?: ($href ? 'a' : 'button');
                $target = $menuAction->shouldOpenInNewTab() ? '_blank' : '_self';

                $classes = Arr::toCssClasses([
                    // Base classes
                    'block w-full text-left px-4 py-2 text-nowrap',

                    // State classes
                    'pointer-events-none opacity-70' => $disabled,
                    
                    // Style-specific classes
                    ...match ($color) {
                        // 'black' => [
                        //     'bg-black text-white hover:bg-gray-700',
                        // ],
                        // 'light' => [
                        //     'bg-gray-200 text-gray-700 hover:bg-gray-300',
                        // ],
                        // 'secondary' => [
                        //     'border border-black bg-white hover:bg-black hover:text-white',
                        // ],
                        default => [
                            'hover:bg-black/5',
                        ],
                    },
                    
                    // 'flex-1' => $grouped,
                    
                    // Color classes
                    // match ($color) {
                    //     'gray' => '',
                    //     default => '',
                    // },
                    // is_string($color) ? "{$color}" : null,
                ]);
            @endphp

            <{{ $tag }}
                {!! $menuAction
                    ->getHtmlAttributeBag()
                    ->merge([
                        'href' => $href,
                        'target' => $target,
                        'disabled' => $menuAction->isDisabled(),
                        'wire:loading.attr' => 'disabled',
                        'type' => $tag == 'button' ? 'button' : false,
                    ], escape: false)
                    ->class([$classes])
                    // ->style([$actionStyles])
                !!}>
                @if ($menuLabel = $menuAction->getLabel())
                    {{ $menuLabel }}
                @endif
            </{{ $tag }}>
            @endforeach
        </div>
    </div>

</div>
