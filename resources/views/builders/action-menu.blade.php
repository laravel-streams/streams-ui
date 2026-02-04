<div x-data="{ open: false }" @click.away="open = false" class="relative inline-block">
    
    <div @click="open = !open">
        <x-ui::action
            :tag="$action->getTag()"
            :href="$action->getUrl()"
            :icon="$action->getIcon()"
            :size="$action->getSize()"
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
            >
            {{ $action->getLabel() }}
        </x-ui::action>
    </div>

    <div x-show="open" 
         x-transition
         class="absolute right-0 mt-2 min-w-48 max-w-xs rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50 overflow-hidden">
        <div class="py-1" role="menu">
            @foreach ($action->getActions() as $menuAction)
                <a href="{{ $menuAction->getUrl() }}"
                   @if($menuAction->shouldOpenInNewTab()) target="_blank" @endif
                   class="flex items-center px-4 py-2 hover:bg-gray-100 text-nowrap {{ $menuAction->isDisabled() ? 'opacity-50 pointer-events-none' : '' }}"
                   role="menuitem">
                    @if($menuAction->getIcon())
                        <x-ui::icon :name="$menuAction->getIcon()" class="mr-3 h-5 w-5" />
                    @endif
                    {{ $menuAction->getLabel() }}
                </a>
            @endforeach
        </div>
    </div>

</div>
