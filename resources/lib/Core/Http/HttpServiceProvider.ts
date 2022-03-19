import { ServiceProvider } from '../Support';
import { Streams, StreamsConfiguration } from '@laravel-streams/api-client';
import { Application } from '../Foundation';


declare module '../types/config' {
    interface Configuration {
        api?: StreamsConfiguration;
    }
}

export class HttpServiceProvider extends ServiceProvider {

    public configure(config: Application['config']) {
        config.api = {
            baseURL: '/api',
            request: {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
            },
            etag   : {
                enabled    : true,
                compression: true,
                manifestKey: 'streams',
            },
        };
    }

    /**
     * Register the service.
     */
    register() {
        this.registerStreams();
    }


    protected registerStreams() {
        const streams = new Streams(this.app.config.api);
        this.app.instance('streams', streams)
            .addBindingGetter('streams')
            .addBindingGetter('streams', 'api');
    }
}


declare module '../Foundation/Application' {
    export interface Application {
        streams: Streams;
        api: Streams;
    }
}
