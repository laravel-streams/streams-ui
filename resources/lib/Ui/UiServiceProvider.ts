import Mousetrap from 'mousetrap';
import { ServiceProvider } from '../Core';
import { ElementCollection } from './ElementCollection';
import './Elements';
import { DefinitionCollection } from './DefinitionCollection';

declare module '../Core/Foundation/Application' {
    interface Application {
        elements: ElementCollection;
        definitions:DefinitionCollection
    }
}

export class UiServiceProvider extends ServiceProvider {
    register() {
        this.app.instance('elements', new ElementCollection()).addBindingGetter('elements');
        this.app.instance('definitions', new DefinitionCollection()).addBindingGetter('definitions');
    }

    boot() {
        let uiAlert = this.app.elements.get('ui-alert');

        class MyAlert extends uiAlert.element {
            sfd() {

            }
        }

        this.app.elements.set(uiAlert.name, MyAlert, uiAlert.definition);
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
