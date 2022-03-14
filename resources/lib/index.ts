///<reference path="global.d.ts"/>

import 'reflect-metadata';
import { app } from './Core';
import { FASTElementDefinition } from '@microsoft/fast-element';
import { constants } from './Ui/constants';

export * from './Core';
export * from './Ui';

// @todo move this to Application.start()
app.events.on('Application:start', values => {
    console.log(values, app, app.elements);
    for ( const item of app.elements ) {
        app.definitions.set(item.name, new FASTElementDefinition(item.element, item.definition).define());
    }
});

window[ 'ui' ] = module.exports;
