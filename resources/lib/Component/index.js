import { walk } from "../util/walk";
import Directive from "../Directive";

export default class Component {

    constructor(element) {

        this.element = element;

        this.id = element.getAttribute('ui:' + 'id');

        this.name = element.getAttribute('ui:' + 'name');

        const data = JSON.parse(this.extractAttribute('data'));

        console.log(name);
        console.log(data);

        this.data = data || {};

        this.initialize();
    }

    extractAttribute(name) {

        const value = this.element.getAttribute('ui:' + name);

        this.element.removeAttribute('ui:' + name);

        return value;
    }

    initialize() {
        this.directives = this.extractDirectives();
    }

    extractDirectives() {

        return Array.from(this.element.children).map(child => {
            Array.from(child.getAttributeNames()
                .filter(name => name.match(new RegExp([
                    'ui:click',
                    'ui:keydown',
                    'ui:submit',
                    'ui:listen',
                    'ui:poll',
                ].join('|'))))
                .map(name => {
                    return new Directive(name, this, child);
                }))
        });
    }

    get(name) {
        return this.data[name];
    }

    walk(callback, callbackWhenNewComponentIsEncountered = element => { }) {
        walk(this.element, (node) => {

            const element = node;

            // Skip the root component element.
            if (element.isSameNode(this.element)) { callback(element); return; }

            // If we encounter a nested component, skip walking that tree.
            //if (element.isComponentRootEl()) {
            if (element.hasAttribute('id')) {

                callbackWhenNewComponentIsEncountered(element)

                return false;
            }

            callback(element)
        })
    }
}
