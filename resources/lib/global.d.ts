declare global {
    interface StreamsGlobal {
        ui: typeof import('./index');
    }

    interface Window {
        streams: StreamsGlobal;
    }
}
