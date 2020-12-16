import { AxiosRequestConfig } from 'axios';
import { Application } from './Application';
export interface IServiceProvider {
    app: Application;
    register?(): void;
    boot?(): void;
}
export interface IConfig {
    prefix?: string;
    debug?: boolean;
    csrf?: string;
    delimiters?: [string, string];
    http?: AxiosRequestConfig;
}
