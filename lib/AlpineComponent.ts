import { injectable } from '@streams/core';

export interface AlpineComponent {
}
export abstract class AlpineComponent {
    $el:HTMLElement
    $nextTick: (cb:Function) => void
    $refs:any
    $watch: (event:string, cb:Function) => void
}
