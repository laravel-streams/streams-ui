import { color } from 'csx';

export const lighten    = (val: string, percent: string | number) => color(val).lighten(percent, true).toHexString();
export const darken     = (val: string, percent: string | number) => color(val).darken(percent, true).toHexString();
export const fade       = (val: string, percent: string | number) => color(val).fade(percent).toHexString();
export const tint       = (val: string, weight: number) => color(val).tint(weight).toHexString();
export const saturate   = (val: string, percent: string | number) => color(val).saturate(percent, true).toHexString();
export const desaturate = (val: string, percent: string | number) => color(val).desaturate(percent, true).toHexString();
export const mix        = (val: string, mix: string, weight?: number) => color(val).mix(mix, weight).toHexString();
export const invert     = (val: string) => color(val).invert().toHexString();

export default {
    lighten,
    darken,
    fade,
    tint,
    saturate,
    desaturate,
    mix,
    invert
}



