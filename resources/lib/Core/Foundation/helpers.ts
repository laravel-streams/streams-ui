import { app, Application } from './Application';

export const onStarted = (cb: (app: Application) => void) => {
    if ( app.isStarted() ) {
        return cb(app);
    }
    app.events.on('Application:started', () => cb(app));
};
export const onBooted = (cb: (app: Application) => void) => {
    if ( app.isBooted() ) {
        return cb(app);
    }
    app.events.on('Application:booted', () => cb(app));
};
