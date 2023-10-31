import morphdom from "morphdom";
import Event from ".";

export default class Click /*extends Event*/ {
    
    constructor(directive) {

        this.directive = directive;

        this.initialize();
    }

    initialize() {
        this.directive.element.addEventListener('click', async (event) => {

            if (this.directive.modifiers.includes('prevent')) {
                event.preventDefault();
            }

            //const params = new URLSearchParams(this.directive.component.data);

            const method = this.directive.element.getAttribute(this.directive.name);

            if (method.startsWith('javascript:')) {

                const script = document.createElement("script");

                script.text = method.substr(11);

                document.body.appendChild(script);

                return;
            }

            const response = await fetch('/streams/ui/' + this.directive.component.name + '/' + method + '?data=' + JSON.stringify(this.directive.component.data));

            const json = await response.json();

            morphdom(event.target.parentNode, json.dom);

            this.directive.component.id = json.data.id;

            this.directive.component.data = json.data;
        });
    }
}
