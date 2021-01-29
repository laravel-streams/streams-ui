///<reference path="../types/alpinejs.d.ts"/>

import { UiServiceProvider }     from './UiServiceProvider';
import { AlpineJS }              from '../types/alpinejs';
import { ExtendedKeyboardEvent } from 'mousetrap';

declare global {
    export interface StreamsGlobalUi {
        UiServiceProvider: typeof UiServiceProvider
    }

    export interface StreamsGlobal {
        ui:StreamsGlobalUi// typeof import('./index')
    }
    export interface Window {
        Alpine:AlpineJS
    }

}

export interface Hotkey {
    keys: string[]
    callback?: (event: ExtendedKeyboardEvent, combo: string) => any
    using?: 'bind' | 'bindGlobal' | 'trigger'
    action?: string
}

export interface Hotkeys {
    [ key: string ]: Hotkey
}
