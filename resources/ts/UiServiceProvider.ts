import 'reflect-metadata';
import { ServiceProvider } from '@streams/core';
import EasyMDE             from 'easymde';


type MarkdownProvider = (...args) => Promise<EasyMDE>;

export class UiServiceProvider extends ServiceProvider {
    public register() {

        this.app.instance('modal', () => {
            return {
                show: false,
                open() { this.show = true; },
                close() { this.show = false; },
                isOpen() { return this.show === true; },
            };
        });

        // 1: this doesn't really make sense though, you want probably want to bind the options into the container.
        this.app.factory('markdown', () => {
            return (options) => {
                return new EasyMDE(options);
            };
        });
        let easyMDE = this.app.get<any>('markdown')({
            // options
        });


        // 2: As mentioned in 1, you can bind the options into the IoC container
        this.app.instance('markdown.options', {
            // easymde options
        });
        // or, to force some code completion into the options, which is sweet,
        // cause there's a lot of them, you can do it like this. Try it out, set an option, vscode should show you code-completion dialog
        this.app.instance('markdown.options', <EasyMDE.Options>{
            autofocus: true,
            // easymde options
        });

        // again, we use interfaces as type, this enables code completion and type-checking. You simply can't screw up the configuration like this
        // want to do something here like `$this->app->bind('markdown', function(Application app){});` ? this is it.
        this.app.factory('markdown', () => {
            const options       = this.app.get<EasyMDE.Options>('markdown.options');
            options.uploadImage = true;
            return new EasyMDE(options);
        });

        // override / extend options
        let options      = this.app.get<EasyMDE.Options>('markdown.options');
        options.autosave = {
            delay   : 1,
            enabled : true,
            uniqueId: 'markdown',
        };
        this.app.instance('markdown.options', options);
        let easyMDE2 = this.app.get<EasyMDE>('markdown');
        easyMDE2.toTextArea();

        // 3: However, those approaches means that if you include the ui/index.js in your page. it will ALWAYS have EasyMDE in the bundle.
        // You can also use async/await to dynamic import easymde. this will have webpack create a seperate 'chunk' .js file, which will be loaded on demand when you actually need it
        this.app.bind('markdown').toProvider<any>((ctx) => {
            return async (...args) => {
                console.log(args);
                const EasyMDEClass: typeof EasyMDE = (await import('easymde')) as any;
                const options                      = this.app.get<EasyMDE.Options>('markdown.options');
                options.uploadImage                = true;
                return new EasyMDEClass(options);
            };
        });

        const markdownProvider = this.app.get<MarkdownProvider>('markdown');0
        markdownProvider('arg1', 'arg2', 3).then(easyMde => {
            easyMde.toTextArea();
        });

        // 4: in any case, you want to start with the basics. that's typescript and inversify.
        // - https://www.typescriptlang.org/docs/
        // - https://github.com/inversify/InversifyJS#the-basics


    }

    // public boot() {
    // }
}
