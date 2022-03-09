import { ServiceProvider } from '../Core';
import { ElementCollection } from './ElementCollection';
import './Elements';
import { DefinitionCollection } from './DefinitionCollection';
declare module '../Core/Foundation/Application' {
    interface Application {
        elements: ElementCollection;
        definitions: DefinitionCollection;
    }
}
export declare class UiServiceProvider extends ServiceProvider {
    register(): void;
    boot(): void;
    bootKeymap(): void;
}
