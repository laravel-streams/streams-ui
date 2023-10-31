import morphdom from "morphdom";
import Event from ".";

export default class Keydown /*extends Event*/ {
    
    constructor(directive) {

        this.directive = directive;

        this.initialize();
    }

    initialize() {
        this.directive.component.element.addEventListener('keydown', async (event) => {

            if (this.directive.modifiers.includes('prevent')) {
                event.preventDefault();
            }
            
            if (
                this.directive.modifiers[0]
                && event.key.toLowerCase() !== this.directive.modifiers[0]
            ) {
                return;
            }

            const params = new URLSearchParams(this.directive.component.data);

            const method = this.directive.component.element.getAttribute(this.directive.name) || 'render';

            const response = await fetch('/streams/ui/' + this.directive.component.name + '/' + method + '?' + params);

            const json = await response.json();

            morphdom(this.directive.component.element, json.dom);

            this.directive.component.id = json.data.attributes['ui:id'];

            this.directive.component.data = json.data;
        });
    }
}
