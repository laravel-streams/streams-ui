import { app } from '../../Core';


export function element(name:string):ClassDecorator {
    return (cls:any) => {
        app.events.on('Application:boot', values => {
            app.elements.add(name, cls);
        })
        return cls;
    }
}
