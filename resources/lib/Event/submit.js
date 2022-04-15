import morphdom from "morphdom";
import Event from ".";

export default class Submit /*extends Event*/ {
    
    constructor(directive) {

        this.directive = directive;

        this.initialize();
    }

    initialize() {
        this.directive.component.element.addEventListener('submit', async (event) => {

            const params = new URLSearchParams(this.directive.component.data);

            const method = this.directive.component.element.getAttribute(this.directive.name) || 'render';

            const response = await fetch('/cp/ui/' + this.directive.component.data.component + '/' + method + '?' + params);

            const json = await response.json();

            morphdom(this.directive.component.element, json.dom);
        });
    }
}    
