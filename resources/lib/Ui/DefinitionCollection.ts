import { FASTElementDefinition } from '@microsoft/fast-element';
import { Collection } from '../Core';

export interface DefinitionCollectionItem {
    name: string;
    definition: FASTElementDefinition;
}

export class DefinitionCollection extends Collection<DefinitionCollectionItem> {

    public set(name: string, definition: FASTElementDefinition): this {
        if ( this.has(name) ) {
            let index = this.findIndex(e => e.name === name);
            this.splice(index, 1, { name, definition });
            return this;
        }
        this.push({ name, definition });
        return this;
    }

    public get(name): DefinitionCollectionItem {
        return this.find(e => e.name === name);
    }

    public has(name): boolean {
        return this.find(e => e.name === name) !== undefined;
    }
}
