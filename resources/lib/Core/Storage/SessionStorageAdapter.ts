import { injectable } from 'inversify';
import { StorageAdapter } from './StorageAdapter';

export class SessionStorageAdapter extends StorageAdapter {
    constructor() {
        super(window.sessionStorage);
    }
}
