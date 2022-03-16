import { Application, inject, injectable } from '../../Core';
import { Theme } from './Theme';
import { interfaces } from 'inversify';
import Newable = interfaces.Newable;

@injectable()
export class ThemeManager {
    @inject('app') app: Application;
    themes: Record<string, Newable<Theme>> = {};
    active?: Theme;

    register(name: string, theme: Newable<Theme>) {
        this.themes[ name ] = theme;
    }

    load(name: string) {
        const Class    = this.themes[ name ];
        const instance = new Class(this.app.ui);
        this.active    = instance;
        instance.onLoad();

    }

    unload() {

    }
}
