import { FASTElementDefinition } from '@microsoft/fast-element';
import { Collection } from '../Core';
export interface DefinitionCollectionItem {
    name: string;
    definition: FASTElementDefinition;
}
export declare class DefinitionCollection extends Collection<DefinitionCollectionItem> {
    set(name: string, definition: FASTElementDefinition): this;
    get(name: any): DefinitionCollectionItem;
    has(name: any): boolean;
}
