import EasyMDE   from 'easymde';
import { Field } from './Field';

export class Markdown extends Field {

    EasyMDE: typeof EasyMDE;
    easyMDE: EasyMDE;
    defaults = {
        EasyMDE: {},
    };

    protected async load() {
        await import('../../resources/scss/inputs/markdown.scss' as any);
        this.EasyMDE = (await import('easymde')).default;
        this.easyMDE = new this.EasyMDE({
            element: this.element,
            ...this.options.EasyMDE,
        });
    }
}
