import 'reflect-metadata';

import { ServiceProvider } from '@streams/core';

import { default as Modals } from './Modals';
import { default as Surfaces } from './Surfaces';

export class UiServiceProvider extends ServiceProvider {

    public register() {

        this.app.factory('modal', () => {
            return Modals;
        });

        this.app.factory('surfaces', () => {
            return Surfaces;
        });

        // this.app.factory('markdown', (options) => {
        //     return new EasyMDE(options);
        // });

        this.app.bind('markdown').toProvider<any>((ctx) => {
            return async (options) => {

                const EasyMDE = (await import('easymde')).default as any;
                return new EasyMDE(options);
            };
        });

        // - https://www.typescriptlang.org/docs/
        // - https://github.com/inversify/InversifyJS#the-basics
    }

    // public boot() {
    // }
}
