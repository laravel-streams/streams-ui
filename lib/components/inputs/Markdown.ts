import EasyMDE             from 'easymde';
import { AlpineComponent } from '../AlpineComponent';
import { Input }           from './Input';

const log = require('debug')('ui.Markdown');


export class Markdown extends Input {

    EasyMDE: typeof EasyMDE;
    easyMDE: EasyMDE;
    options = {
        EasyMDE: {},
    };

    async load() {
        import('../../../resources/scss/inputs/markdown.scss' );
        log('loaded', this);
    }

    async init() {
        this.EasyMDE = (await import('easymde')).default;
        this.easyMDE = new this.EasyMDE({
            element: this.$el,
            ...this.options,
        });
        log('init', this);
    }
}
