import { Field } from './Field';

const log = require('debug')('ui.Markdown');

export class Input extends Field {

    constructor(options: any) {
        super();
        Object.assign(this, options);
        log('constructor', new.target.name, this);
        this.load();
    }

    protected async load() { }

    public async init() {}
}

