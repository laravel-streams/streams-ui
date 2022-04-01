import Alpine from 'alpinejs';
import morphdom from 'morphdom';

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

        /**
         * Find and initialize all
         * components found on screen.
         */
        Array.from(document.querySelectorAll(`[${this.config.prefix}\\:id]`)).forEach(element => {
            this.components[element.getAttribute(`${this.config.prefix}:id`)] = new Component(element);
        });
    }
}

window.streams = window.streams || {};

window.streams.ui = new UI;

window.streams.ui.start();
