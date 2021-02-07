import { ServiceProvider }   from '@streams/core';
import axios                 from 'axios';
import { Input, Markdown }   from './components/inputs';
import Mousetrap             from 'mousetrap';
import { Form, FormOptions } from './components/Form';
import { Hotkeys }           from './types';
import { Modal }             from './components/Modal';

const log = require('debug')('ui.UiServiceProvider');

export class UiServiceProvider extends ServiceProvider {

    public async boot() {
        this.app.get<Function>('hotkeys.bind')();
    }

    public async register() {
        this.registerHotkeys();
        this.registerAxios();
        this.app.factory('modal', url => new Modal(url));
        this.app.factory('surfaces', url => new Modal(url));
        this.app.factory('form', (options: FormOptions) => new Form(options));
        this.app.factory('input.input', (options) => new Input(options));
        this.app.factory('input.markdown', (options) => new Markdown(options));
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


    // public boot() {
    // }
}
