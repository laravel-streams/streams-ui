import 'reflect-metadata';
import { ServiceProvider } from '@streams/core';
import EasyMDE from 'easymde';

const axios = require('axios');

export class UiServiceProvider extends ServiceProvider {
    public register() {

        this.app.instance('modal', (url) => {
            return {
                show: false,
                content: url,
                open() { this.show = true; },
                close() { this.show = false; },
                isOpen() { return this.show === true; },
                load(url) {

                    const self = this;

                    axios.get(url)
                        .then(function (response) {
                            self.content = response.data;
                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        })
                        .then(function () {
                            // always executed
                        });

                    this.content = url;
                },
            };
        });

        /**
         * Ideally we could pack this in markdown/index.js?
         * Which would load and bind itself and be included
         * by markdown.blade.php -> Asset::add
         */
        this.app.factory('markdown', (options) => {
            return new EasyMDE(options);
        });

        /**
         * Lazy loading is not currently working.
         * 
         * Issue 1: Chunk mapping
         * Issue 2: Entry point? SCSS has to be piped through .ts as workaround.
         */
        // this.app.bind('markdown').toProvider<any>((ctx) => {
        //     return async (options) => {
        //         const EasyMDE = (await import('easymde')).default as any;
        //         return new EasyMDE(options);
        //     };
        // });

        // - https://www.typescriptlang.org/docs/
        // - https://github.com/inversify/InversifyJS#the-basics
    }

    // public boot() {
    // }
}
