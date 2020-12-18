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

        this.app.binding('markdown', (options) => {
            return new EasyMDE(options);
        });
    }

    // public boot() {
    // }
}
