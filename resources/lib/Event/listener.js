import morphdom from "morphdom";
import Event from ".";

export default class Listener /*extends Event*/ {
    
    constructor(directive) {

        this.directive = directive;

        this.initialize();
    }

    initialize() {
        const attribute = this.directive.component.element.getAttribute(this.directive.name) || 'render';

        const [event, method] = attribute.split('.');

        window.addEventListener(event, async () => {

            const params = new URLSearchParams(this.directive.component.data);

            const response = await fetch('/cp/ui/' + this.directive.component.data.component + '/' + method + '?' + params);

            const json = await response.json();

            morphdom(this.directive.component.element, json.dom);
        });
    }
}    
