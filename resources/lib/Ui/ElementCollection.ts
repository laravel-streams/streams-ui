import { Collection } from '../Core';
import { LitElement } from 'lit-element';

export class ElementCollection extends Collection<{name:string, element:typeof LitElement}> {
    public add(name: string, element: typeof LitElement): this {
        this.push({name, element})
        return this;
    }

    public set(name: string, element: typeof LitElement): this {
        if(this.has(name)){
            let index =this.findIndex(e => e.name === name);
            this.splice(index,1);
        }
        this.add(name, element);
        return this;
    }

    public get(name): typeof LitElement {
        return this.find(e => e.name === name).element;
    }

    public has(name):boolean {
        return this.find(e => e.name === name) !== undefined;
    }
}
