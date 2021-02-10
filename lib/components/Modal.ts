import { AlpineComponent }       from './AlpineComponent';
import { AxiosInstance }         from 'axios';
import { discoverAndInitialize } from '../utils';
import { app }                   from '@streams/core';


const log = require('debug')('ui.Modal');

export class Modal extends AlpineComponent {
    constructor(public url: string) {
        super();
        log('constructor', this);
    }

    init() {
        log('init', this);
    }

    show: boolean   = false;
    content: string = this.url;

    open() { this.show = true; }

    close() { this.show = false; }

    isOpen() { return this.show === true; }

    async load(url) {
        const self = this;
        try {
            const response = await app.get<AxiosInstance>('axios').get(url);
            self.content   = response.data;
            discoverAndInitialize();
        } catch ( e ) {
            log('load', 'error', e);
        }
        this.content = url;
    }
}
