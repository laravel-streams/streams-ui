import Alpine from 'alpinejs';

import Component from './Component/index';

window.Alpine = Alpine;

Alpine.start();

class UI {

    constructor(config = {}) {

        const defaults = {
            prefix: 'ui'
        }

        this.config = Object.assign({}, defaults, config);

        this.components = {};
    }

    start() {

        const components = Array.from(
            document.querySelectorAll(`[${this.config.prefix}\\:id]`)
        );

        components.forEach(element => {

            const id = element.getAttribute(`${this.config.prefix}:id`);

            this.components[id] = new Component(element);
        });

        // DOMElement.rootComponentElementsWithNoParents().forEach(elemenet => {
        //     this.components.addComponent(
        //         new Component(elemenet, this.connection)
        //     );
        // });

        // this.onLoadCallback()
        // dispatch('livewire:load')

        // window.addEventListener('beforeunload', () => {
        //     this.components.tearDownComponents()
        // })

        // document.addEventListener('visibilitychange', () => {
        //     this.components.livewireIsInBackground = document.hidden
        // }, false);
    }

    components() {
        return this.components;
    }
}

window.streams = window.streams || {};

window.streams.ui = new UI;

window.streams.ui.start();
