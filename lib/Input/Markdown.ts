import EasyMDE             from 'easymde';
import { AlpineComponent } from '../AlpineComponent';
import { unmanaged }       from '@streams/core';

const log = require('debug')('ui.Markdown');


export class Markdown extends AlpineComponent {

    EasyMDE: typeof EasyMDE;
    easyMDE: EasyMDE;
    options = {
        EasyMDE: {},
    };

    constructor(options: any) {
        super();
        Object.assign(this, options);
        log('constructor', this);
        this.load();
    }

    async load() {
        // @ts-ignore
        import('../../resources/scss/inputs/markdown.scss' );
        log('loaded', this);
    }

    protected async init() {
        // @ts-ignore
        this.EasyMDE = (await import('easymde')).default;
        this.easyMDE = new this.EasyMDE({
            element: this.$el,
            ...this.options,
        });
        log('init', this);
    }
}
