import { ServiceProvider } from './Support';
import { StorageServiceProvider } from './Storage';

export class CoreServiceProvider extends ServiceProvider {
    providers = [
        StorageServiceProvider,
    ]
}
