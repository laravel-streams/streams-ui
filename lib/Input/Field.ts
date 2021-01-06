import { injectable } from '@streams/core';

@injectable()
export abstract class Field {
    element: HTMLElement;
    options?: any;
    defaults: any = {};

    public async init(selector: string, options?: any): Promise<this> {
        this.element = document.querySelector(selector);
        this.options = {
            ...this.defaults,
            ...options,
        };

        await this.load();
        return this;
    }

    protected abstract load(): Promise<any>
}
