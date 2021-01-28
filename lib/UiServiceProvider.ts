import { ServiceProvider }                  from '@streams/core';
import axios, { AxiosInstance }             from 'axios';
import { Input, Markdown }                  from './Input';
import Mousetrap, { ExtendedKeyboardEvent } from 'mousetrap';
import { Debug }             from 'debug';
import { Form, FormOptions } from './Form';

export interface Hotkey {
    keys: string[]
    callback?: (event: ExtendedKeyboardEvent, combo: string) => any
    using?: 'bind' | 'bindGlobal' | 'trigger'
    action?: string
}

export interface Hotkeys {
    [ key: string ]: Hotkey
}

const log: Debug['log'] = require('debug')('ui.UiServiceProvider');

export class UiServiceProvider extends ServiceProvider {

    public async boot() {
        this.app.get<Function>('hotkeys.bind')();
    }

    public async register() {
        this.registerHotkeys();
        this.registerModal();
        this.registerInputs();
        this.registerSurfaces();
        this.registerAxios();
        this.app.factory('form', (options: FormOptions) => new Form(options))
        this.app.factory('input.markdown', (options) => new Markdown(options))

    }

    protected registerAxios() {
        // this.app.instance('axios', axios); = not needed, you can just import axios anywhere
        // only needed if you do axios.create(), it creates an instance with some pre-defined config
        // below it does the same as default Laravel resources/js/bootstrap.js does, but for an instance
        this.app.dynamic('axios', () => {
            return axios.create({
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });
        });
    }

    protected registerHotkeys() {
        this.app.factory('hotkeys.bind', () => {
            let hotkeys = this.app.get<Hotkeys>('hotkeys');
            Object.values(hotkeys).forEach(hotkey => {
                let args = [ hotkey.keys, hotkey.callback, hotkey.action ].filter(Boolean);
                (Mousetrap as any)[ hotkey.using || 'bind' ](...args);
            });
        });
        this.app.instance('hotkeys', {
            help: {
                keys    : [ '?' ],
                callback: (event) => {
                    event.preventDefault();
                    event.target.form.submit();
                    alert();
                },
                //using   : 'bind',
                //action  : null,
            },
            save: {
                keys    : [ 'ctrl+s', 'command+s' ],
                callback: (event) => {
                    event.preventDefault();
                    event.target.form.submit();
                    alert();
                },
            },
        });
    }

    protected registerInputs() {
        this.app.binding('input.input', Input);
        //this.app.binding('input.markdown', Markdown);
    }

    protected registerModal() {
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
    }

    protected registerSurfaces() {
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
    }

    // public boot() {
    // }
}
