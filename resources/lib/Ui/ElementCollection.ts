import { Collection } from '../Core';
import { FASTElement, PartialFASTElementDefinition } from '@microsoft/fast-element';

export interface ElementCollectionItem {
    name: string,
    element: typeof FASTElement,
    definition: PartialFASTElementDefinition
}

export class ElementCollection extends Collection<ElementCollectionItem> {
    public add(name: string, element: typeof FASTElement, definition: PartialFASTElementDefinition): this {
        this.push({ name, element, definition });
        return this;
    }

    public set(name: string, element: typeof FASTElement, definition: PartialFASTElementDefinition): this {
        if ( this.has(name) ) {
            let index = this.findIndex(e => e.name === name);
            this.splice(index, 1);
        }
        this.add(name, element, definition);
        return this;
    }

    public get(name): ElementCollectionItem {
        return this.find(e => e.name === name);
    }


    public has(name): boolean {
        return this.find(e => e.name === name) !== undefined;
    }
}
