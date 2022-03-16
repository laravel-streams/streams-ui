import { app, isString, makeLog } from '../../../Core';
import { FASTElement, PartialFASTElementDefinition } from '@microsoft/fast-element';

const log              = makeLog('ui:decorators:element');
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
    let fn = (type: typeof FASTElement): any => {
        class Type extends type {
            constructor() {
                super();
                log('constructed ', definition.name, { definition, instance: this });
            }
        }

        app.events.on('Application:boot', values => {
            log('registered ', definition.name, { definition, element: Type });
            app.ui.elements.add(definition.name, Type as any, definition);
        });

        return Type;
    };
    return fn as any;
}
