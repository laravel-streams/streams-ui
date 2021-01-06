import 'reflect-metadata';
import { ServiceProvider }      from '@streams/core';
import axios, { AxiosInstance } from 'axios';
import { Input, Markdown }      from './Input';

export class UiServiceProvider extends ServiceProvider {
    public register() {
        this.app.instance('axios', axios);
        this.app.binding('field.input', Input);
        this.app.binding('field.markdown', Markdown);
        this.app.ctxfactory('modal', ctx => (url) => {
            return {
                show   : false,
                content: url,
                open() { this.show = true; },
                close() { this.show = false; },
                isOpen() { return this.show === true; },
                load(url) {

                    const self = this;

                    ctx.container.get<AxiosInstance>('axios').get(url)
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

        this.app.ctxfactory('surfaces', ctx => (url) => {

            return {
                show   : false,
                content: url,
                open() { this.show = true; },
                close() { this.show = false; },
                isOpen() { return this.show === true; },
                load(url) {

                    const self = this;

                    ctx.container.get<AxiosInstance>('axios').get(url)
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

                const EasyMDE = (await import('easymde')) as any;
                return new EasyMDE(options);
            };
        });

        // - https://www.typescriptlang.org/docs/
        // - https://github.com/inversify/InversifyJS#the-basics
    }

    // public boot() {
    // }
}
