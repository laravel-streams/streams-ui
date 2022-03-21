import { Application } from '../Foundation';


export const isServiceProviderClass = (value: any): value is IServiceProviderClass => !(value instanceof ServiceProvider);

export class ServiceProvider implements IServiceProvider {

    constructor(public app: Application) {}
}

export type Constructor<Type = any> = new (...args: any[]) => Type

export type IServiceProviderClass = {
    new(app: Application): IServiceProvider
}

export interface IServiceProvider {

    app: Application;
    providers?: IServiceProviderClass[];
    singletons?: Record<string, Constructor>;
    bindings?: Record<string, Constructor>;

    configure?(config: Application['config']): void;

    register?(): any | Promise<any>;

    boot?(): any | Promise<any>;
}
