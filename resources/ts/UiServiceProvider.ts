import 'reflect-metadata';
import { ServiceProvider } from '@streams/core';
import axios               from 'axios';

export class UiServiceProvider extends ServiceProvider {
    public register() {
        this.app.instance('axios',axios);
        this.app.factory('modal', (url) => {
            return {
                show   : false,
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

        this.app.factory('surfaces', (url) => {

            return {
                show   : false,
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

        // this.app.factory('markdown', (options) => {
        //     return new EasyMDE(options);
        // });

        this.app.bind('markdown').toProvider<any>((ctx) => {
            return async (options) => {

                const EasyMDE = (await import('easymde')).default as any;
                return new EasyMDE(options);
            };
        });

        // - https://www.typescriptlang.org/docs/
        // - https://github.com/inversify/InversifyJS#the-basics
    }

    // public boot() {
    // }
}
