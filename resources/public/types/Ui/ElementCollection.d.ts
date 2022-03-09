import { Collection } from '../Core';
import { FASTElement, PartialFASTElementDefinition } from '@microsoft/fast-element';
export interface ElementCollectionItem {
    name: string;
    element: typeof FASTElement;
    definition: PartialFASTElementDefinition;
}
export declare class ElementCollection extends Collection<ElementCollectionItem> {
    add(name: string, element: typeof FASTElement, definition: PartialFASTElementDefinition): this;
    set(name: string, element: typeof FASTElement, definition: PartialFASTElementDefinition): this;
    get(name: any): ElementCollectionItem;
    has(name: any): boolean;
}
