import { Container } from 'inversify';
import EasyMDE from 'easymde';

declare class Application extends Container {
    constructor(options?: any)

    alert()
}

interface Streams {
    Application: typeof Application
    EasyMDE: typeof EasyMDE
}

interface Window {
    streams: Streams
}
