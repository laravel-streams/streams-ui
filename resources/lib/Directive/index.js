import morphdom from "morphdom";
import Submit from "../Event/submit.js";
import Click from "./../Event/click.js";
import Keydown from "../Event/keydown.js";
import Listener from "../Event/listener.js";
import Poll from "../Event/poll.js";

export default class Directive {

    constructor(name, component) {

        this.name = name;
        this.component = component;

        const [type, ...modifiers] = name.replace(new RegExp('ui:'), '').split('.');

        this.type = type;
        this.modifiers = modifiers;

        this.event = null;

        this.initialize();
    }

    initialize() {
        
        switch (this.type) {
            case 'click':
                this.event = new Click(this);
                break;
            case 'keydown':
                this.event = new Keydown(this);
                break;
            case 'submit':
                this.event = new Submit(this);
                break;
            case 'listen':
                this.event = new Listener(this);
                break;
            case 'poll':
                this.event = new Poll(this);
                break;

            default:
                break;
        }
    }
}
