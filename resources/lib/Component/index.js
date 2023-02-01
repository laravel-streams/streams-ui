import { walk } from "../util/walk";
import Directive from "../Directive";

export default class Component {

    constructor(element) {

        this.element = element;

        this.id = element.getAttribute('ui:' + 'id');

        const data = JSON.parse(this.extractAttribute('data'));

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
        return Array.from(this.element.getAttributeNames()
            .filter(name => name.match(new RegExp('ui:')))
            .map(name => {
                return new Directive(name, this);
                //return new ElementDirective(type, modifiers, name, this.el)
            }));
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
