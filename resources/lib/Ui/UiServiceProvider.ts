import Mousetrap from 'mousetrap';
import { Application, ServiceProvider } from '../Core';
import { Toolbar } from './Elements';
import { StreamsUiConfiguration } from './types';
import { UIManager } from './UIManager';
import { FASTElementDefinition } from '@microsoft/fast-element';
import { DefaultTheme, ThemeManager } from './Theme';

declare module '../Core/Foundation/Application' {
    interface Application {
        ui: UIManager;
    }
}
declare module '../Core/types/config' {
    interface Configuration {
        ui?: StreamsUiConfiguration;
    }
}


export class UiServiceProvider extends ServiceProvider {
    configure(config: Application['config']) {
        config.ui = {
            theme       : 'default',
            fontPath    : '/vendor/streams/ui/fonts',
            rootSelector: '#root',
            normalize   : true,
        };
    }

    register() {
        this.app.singleton('ui', UIManager).addBindingGetter('ui');
        this.app.singleton('themes', ThemeManager).addBindingGetter('themes');

        // @todo move this to Application.start()
        this.app.events.on('Application:start', values => {
            this.app.ui.themes.load(this.app.config.ui.theme);

            console.log(values, this.app, this.app.ui.elements);
            for ( const item of this.app.ui.elements ) {
                this.app.ui.definitions.set(item.name, new FASTElementDefinition(item.element, item.definition).define());
            }
        });
    }

    boot() {
        this.app.ui.themes.register('default', DefaultTheme);
        let uiToolbar = this.app.ui.elements.get<typeof Toolbar>('ui-toolbar');

        uiToolbar.element.defaultCss.space.backgroundColor = 'black';

        let uiAlert = this.app.ui.elements.get('ui-alert');

        class MyAlert extends uiAlert.element {
            sfd() {

            }
        }

        this.app.ui.elements.set(uiAlert.name, MyAlert, uiAlert.definition);
    }


    bootKeymap() {

        const keymaps = document.querySelectorAll('[data-keymap]');

        keymaps.forEach(function (trigger: HTMLElement) {

            // Mousetrap.stopCallback = function(e, element, combo) {

            //     // if the element has the class "mousetrap" then no need to stop
            //     if ((' ' + element.className + ' ').indexOf(' mousetrap ') > -1) {
            //         return false;
            //     }

            //     // stop for input, select, and textarea
            //     return element.tagName == 'INPUT' || element.tagName == 'SELECT' || element.tagName == 'TEXTAREA' || (element.contentEditable && element.contentEditable == 'true');
            // };

            Mousetrap.bind(trigger.dataset.keymap, function (event) {
                event.preventDefault();
                trigger.tagName == 'INPUT' ? trigger.focus() : trigger.click();
            });
        });

        // window.streams.core.app.surfaces = function () {
        //     return {

        //         content: '',
        //         enabled: false,

        //         enableSurfaces() {

        //             this.enabled = true;

        //             return this;
        //         },

        //         disableSurfaces() {

        //             this.enabled = false;

        //             return this;
        //         },

        //         loadSurface(params) {

        //             if (!this.enabled) {
        //                 this.enableSurfaces();
        //             }

        //             // Check if target is a selector
        //             if (params.target.includes('#') || params.target.includes('.')) {

        //                 this.content = document.querySelector(params.target).innerHTML;

        //                 return;

        //             } else {

        //                 window.streams.core.axios.get(params.target).then((response) => {
        //                     this.content = response.data;
        //                 });

        //                 return;
        //             }
        //         }
        //     };
        // }
    }
}
