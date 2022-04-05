import morphdom from "morphdom";

export default class Component {

    constructor(element) {

        this.element = element;

        this.id = element.getAttribute('id');

        const initialData = JSON.parse(this.extractAttribute('data'));

        this.data = initialData || {};

        this.initialize();
    }

    extractAttribute(name) {

        const value = this.element.getAttribute('ui:' + name);

        this.element.removeAttribute(name);

        return value;
    }

    get(name) {
        return this.data[name];
    }

    initialize() {

        this.directives = Array.from(this.element.getAttributeNames()
            .filter(name => name.match(new RegExp('ui:')))
            .map(name => {
                const [type, ...modifiers] = name.replace(new RegExp('ui:'), '').split('.')

                return {
                    'name': name,
                    'type': type,
                    'modifiers': modifiers,
                    'element': this.element
                }
                //return new ElementDirective(type, modifiers, name, this.el)
            }));

            this.directives.forEach(directive => {

                if (directive.type == 'click') {
                    
                    this.element.addEventListener('click', async event => {

                        const params = new URLSearchParams(this.data);

                        const method = directive.element.getAttribute(directive.name) || 'render';

                        const response = await fetch('/cp/ui/' + this.data.component + '/' + method + '?' + params);

                        const json = await response.json();

                        morphdom(event.target, json.dom);
                    });
                }
            });
    }
}
