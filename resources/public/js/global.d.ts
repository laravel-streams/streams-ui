declare global {
    export interface StreamsGlobal {
        ui: typeof import('./');
    }

    export interface Window {
        streams: StreamsGlobal;
    }
}
