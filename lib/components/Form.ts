import { AlpineComponent } from './AlpineComponent';

export interface FormOptions {
    actions: any[]
    attributes: any
    buttons: any[]
    classes: string[]
    component: string
    data: any
    entry: any
    fields: Record<string, { type: string, handle: string, rules: string[], input: any[], stream: any[] }>
    options: any
    rules: Record<string, string[]>
    handle: string
    template: string
    validators: any
    errors: any
    stream: any
}
const log = require('debug')('ui.Form')
export class Form extends AlpineComponent implements FormOptions {
    actions: any[];
    attributes: any;
    buttons: any[];
    classes: string[];
    component: string;
    data: any;
    entry: any;
    fields: Record<string, { type: string, handle: string, rules: string[], input: any[], stream: any[] }>;
    options: any;
    rules: Record<string, string[]>;
    handle: string;
    template: string;
    validators: any;
    errors: any;
    stream: any;

    constructor(options: FormOptions) {
        super();
        Object.assign(this,options)
        log('constructor',this)
        //Object.keys(options).forEach(key => this[ key ] = options[ key ]);
    }

    public init() {
        log('init',this)
    }
}
