import { IConfig, ServiceProvider } from '@streams/core';
import { ExampleClass }             from './ExampleClass';

export class UiServiceProvider extends ServiceProvider {
    public register() {
        // let config = this.app.get<IConfig>('config');
        // this.app.singleton('asdf', ExampleClass);
    }

    // public boot() {
    // }
}
