import morphdom from "morphdom";
import Event from ".";

export default class Click /*extends Event*/ {
    
    constructor(directive) {

        this.directive = directive;

        this.initialize();
    }

    initialize() {
        this.directive.component.element.addEventListener('click', async (event) => {

            if (this.directive.modifiers.includes('prevent')) {
                event.preventDefault();
            }

            //const params = new URLSearchParams(this.directive.component.data);

            const method = this.directive.component.element.getAttribute(this.directive.name) || 'render';

            if (method.startsWith('javascript:')) {

                const script = document.createElement("script");

                script.text = method.substr(11);

                document.body.appendChild(script);

                return;
            }

            const response = await fetch('/cp/ui/' + this.directive.component.data.component + '/' + method + '?data=' + JSON.stringify(this.directive.component.data));

            const json = await response.json();

            morphdom(event.target.parentNode, json.dom);

            this.directive.component.id = json.data.id;

            this.directive.component.data = json.data;
        });
    }
}
