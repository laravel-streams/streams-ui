import morphdom from "morphdom";

export default class Directive {

    constructor(name, component) {

        this.name = name;
        this.component = component;

        const [type, ...modifiers] = name.replace(new RegExp('ui:'), '').split('.');

        this.type = type;
        this.modifiers = modifiers;

        this.initialize();
    }

    initialize() {

        switch (this.type) {
            case 'click':
                this.registerClick();
                break;
            case 'keydown':
                this.registerKeydown();
                break;
            case 'submit':
                this.registerSubmit();
                break;
            case 'listen':
                this.registerEventListener();
                break;

            default:
                break;
        }
    }

    // @todo
    registerClick() {
        this.component.element.addEventListener('click', async () => {

            const params = new URLSearchParams(this.component.data);

            const method = this.component.element.getAttribute(this.name) || 'render';

            if (method.startsWith('javascript:')) {

                const script = document.createElement("script");

                script.text = method.substr(11);

                document.body.appendChild(script);

                return;
            }

            const response = await fetch('/cp/ui/' + this.component.data.component + '/' + method + '?' + params);

            const json = await response.json();

            morphdom(this.component.element, json.dom);
        });
    }

    // @todo
    registerKeydown() {
        this.component.element.addEventListener('keydown', async (event) => {

            if (
                this.modifiers[0]
                && event.key.toLowerCase() !== this.modifiers[0]
            ) {
                return;
            }

            const params = new URLSearchParams(this.component.data);

            const method = this.component.element.getAttribute(this.name) || 'render';

            const response = await fetch('/cp/ui/' + this.component.data.component + '/' + method + '?' + params);

            const json = await response.json();

            morphdom(this.component.element, json.dom);
        });
    }

    // @todo
    registerSubmit() {
        this.component.element.addEventListener('submit', async (event) => {

            const params = new URLSearchParams(this.component.data);

            const method = this.component.element.getAttribute(this.name) || 'render';

            const response = await fetch('/cp/ui/' + this.component.data.component + '/' + method + '?' + params);

            const json = await response.json();

            morphdom(this.component.element, json.dom);
        });
    }

    // @todo
    registerEventListener() {
        const attribute = this.component.element.getAttribute(this.name) || 'render';

            const [event, method] = attribute.split('.');

            window.addEventListener(event, async () => {

                const params = new URLSearchParams(this.component.data);

                const response = await fetch('/cp/ui/' + this.component.data.component + '/' + method + '?' + params);

                const json = await response.json();

                morphdom(this.component.element, json.dom);
            });
    }
}
