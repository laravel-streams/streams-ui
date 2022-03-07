import { ServiceProvider } from '@laravel-streams/core';
import { StorageServiceProvider } from './Storage';
export declare class UiServiceProvider extends ServiceProvider {
    providers: (typeof StorageServiceProvider)[];
    boot(): void;
}
