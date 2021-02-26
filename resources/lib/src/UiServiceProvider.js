import { ServiceProvider } from '@streams/core';

export class UiServiceProvider extends ServiceProvider {

    boot() {

        console.log('Loaded Ui');
        // this.app.factory('modal', () => {
        //     return Modals;
        // });
    }
}
