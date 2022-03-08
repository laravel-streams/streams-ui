///<reference path="global.d.ts"/>

import 'reflect-metadata';
import { app } from './Core';

export * from './Core';
export * from './Ui';

app.events.on('Application:start', values => {
    console.log(values, app, app.elements);
    // let lazyElements = app.elements.filter(el => isPromise(el.element))
    // Promise.resolve(lazyElements.map(e => (e.element as any)())).then(elements => {
    //
    // })
    // let elements = app.elements.filter(el => isPromise(false))
    for ( const item of app.elements ) {
        customElements.define(item.name, item.element);
    }
});

export { app };


window[ 'ui' ] = module.exports;
