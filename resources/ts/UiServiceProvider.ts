import { ServiceProvider } from '@streams/core';

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
        // let config = this.app.get<IConfig>('config');
        // this.app.singleton('asdf', ExampleClass);
    }

    // public boot() {
    // }
}
