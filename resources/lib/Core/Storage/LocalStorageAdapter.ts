import { injectable } from 'inversify';
import { StorageAdapter } from './StorageAdapter';

export class LocalStorageAdapter extends StorageAdapter {
    constructor() {
        super(window.localStorage);
    }
}
