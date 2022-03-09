import { app, isString } from '../../Core';
import { PartialFASTElementDefinition } from '@microsoft/fast-element';
import { importStylesheets } from './importStylesheets';

const isFastDefinition = (val: any): val is PartialFASTElementDefinition => val && val.name;
const isFastName       = (val: any): val is PartialFASTElementDefinition => val && val.name;

export function element(name: string): ClassDecorator
export function element(def: PartialFASTElementDefinition): ClassDecorator
export function element(name: string, def?: Omit<PartialFASTElementDefinition, 'name'>): ClassDecorator
export function element(...args): ClassDecorator {
    let definition: PartialFASTElementDefinition;
    if ( args.length === 2 ) {
        definition = {
            ...args[ 1 ],
            name: args[ 0 ],
        };
    } else if ( isString(args[ 0 ]) ) {
        definition = {
            name: args[ 0 ],
        };
    } else if ( isFastDefinition(args[ 0 ]) ) {
        definition = args[ 0 ];
    }
    return (type: any): any => {
        class Type extends type {
            constructor() {
                super();
                importStylesheets(this as any);
                console.log('hello this is', definition.name, { definition, instance: this });
            }
        }

        app.events.on('Application:boot', values => {
            app.elements.add(definition.name, Type as any, definition);
        });

    };
}
