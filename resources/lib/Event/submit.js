import morphdom from "morphdom";
import Event from ".";

export default class Submit /*extends Event*/ {
    
    constructor(directive) {

        this.directive = directive;

        this.initialize();
    }

    initialize() {
        this.directive.component.element.addEventListener('submit', async (event) => {

            if (this.directive.modifiers.includes('prevent')) {
                event.preventDefault();
            }

            //const params = new URLSearchParams(this.directive.component.data);

            const method = this.directive.element.getAttribute(this.directive.name);
            const action = this.directive.element.getAttribute('action');

            // @todo Support javascript: methods.
            const url = action ? action : '/cp/ui/' + this.directive.component.name + '/' + method;

            const response = await fetch(url, {
                method: 'POST',
                headers:{
                    //'Content-Type': 'application/json',
                    'X-CSRF-Token': CSRF_TOKEN
                },
                body: JSON.stringify(this.directive.component.data),
            });

            // @todo Handle errors. Different response types, etc.
            const json = await response.json();

            morphdom(this.directive.component.element, json.dom);

            this.directive.component.id = json.data.attributes['ui:id'];

            this.directive.component.data = json.data;
        });
    }
}    
