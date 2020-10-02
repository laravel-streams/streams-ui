import { Container } from "inversify";

export class Application extends Container {

    // constructor() {
    //     //alert();
    // }

    alert(message = 'Testing') {
        alert(message);
    }
}
