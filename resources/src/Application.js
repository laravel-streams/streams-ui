import {Container} from 'inversify';


export class Application extends Container {

    constructor(options = {}) {
        super({
            autoBindInjectable : false,
            defaultScope       : 'Transient',
            skipBaseClassChecks: false
        });
        this.bind('options').toConstantValue({
            message: 'Hello!',
            ...options
        })
    }

    alert(){
        alert(this.get('options').message)
    }
}
