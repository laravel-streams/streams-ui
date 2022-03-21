import { Repository } from '../Config';
import { AxiosRequestConfig } from 'axios';
import { IServiceProviderClass } from '../Support';


export type Config =
    Repository<Configuration>
    & Configuration

export interface Configuration {
    debug?: boolean;
    csrf?: string;
}


export interface ApplicationInitOptions {
    providers?: IServiceProviderClass[];
    config?: Configuration;
}
