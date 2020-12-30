import { app } from '@streams/core'

export default {
    
    show: false,
    content: null,

    open() { this.show = true; },
    close() { this.show = false; },
    isOpen() { return this.show === true; },
    
    load(url) {

        const self = this;

        window.streams.core.app.get('http')().get(url)
            .then(function (response) {
                self.content = response.data;
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .then(function () {
                // always executed
            });

        this.content = url;
    },
}
