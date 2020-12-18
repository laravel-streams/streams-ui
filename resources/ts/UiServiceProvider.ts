import 'reflect-metadata';
import { ServiceProvider } from '@streams/core';
import EasyMDE from 'easymde';

export class UiServiceProvider extends ServiceProvider {
    public register() {

        this.app.instance('modal', () => {
            return {
                show: false,
                open() { this.show = true; },
                close() { this.show = false; },
                isOpen() { return this.show === true; },
            };
        });

        // this.app.factory('markdown', (options) => {
        //     return new EasyMDE(options);
        // });

        this.app.bind('markdown').toProvider<any>((ctx) => {
            return async (options) => {

                (await import('easymde')) as any;

                return new EasyMDE(options);
            };
        });

        // - https://www.typescriptlang.org/docs/
        // - https://github.com/inversify/InversifyJS#the-basics
    }

    // public boot() {
    // }
}
