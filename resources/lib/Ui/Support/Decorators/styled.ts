import { FASTElement } from '@microsoft/fast-element';
import { NestedCSSProperties as BaseNestedCSSProperties } from 'typestyle/src/types';
import { TypeStyle } from 'typestyle';
import { create } from '../../Theme/FreeStyle';
import deepmerge from 'deepmerge';
import { app, isFunction, isObject, makeLog, Observable } from '../../../Core';
import { Theme } from '../../Theme/Theme';

const log = makeLog('ui:decorators:styled');

export interface StyledDecoratorOptions {
    observe?: boolean;
    importStylesheets?: boolean;
    importSelector?: string;
}


const resolveStyles = (styles: styled.Styles, theme: Theme): NestedCSSProperties => {
    const resolve = (obj: styled.Styles, theme: Theme): NestedCSSProperties => {
        Object.keys(obj).forEach(key => {
            if ( isFunction(obj[ key ]) ) {
                obj[ key ] = obj[ key ](theme);
            }
            if ( isObject(obj[ key ]) ) {
                resolve(obj[ key ], theme);
            }
        });
        return obj as any;
    };
    let obj       = {};
    obj           = deepmerge(obj, styles, { clone: false });
    return resolve(obj, theme);
};

export function styled(options: StyledDecoratorOptions = {}): ClassDecorator {
    options = {
        observe          : false,
        importStylesheets: false,
        importSelector   : 'link[data-element-import]',
        ...options,
    };

    let fn = function (Class: typeof FASTElement) {
        class Styled extends Class {
            static defaultCss?: styled.CSS;
            css?: Observable & styled.CSS;
            protected typestyle: TypeStyle;
            protected createStyle: StyleFunction;

            constructor() {
                super();
                this.typestyle                             = new TypeStyle({ autoGenerateTag: false });
                this.typestyle[ '_freeStyle' ]             = create();
                this.typestyle[ '_lastFreeStyleChangeId' ] = this.typestyle[ '_freeStyle' ].changeId;

                let style = document.createElement('style');
                style.setAttribute('type', 'text/css');
                this.$fastController.element.shadowRoot.appendChild(style);
                this.typestyle.setStylesTarget(style);

                this.createStyle = (className: string, styles: styled.Styles) => {
                    let obj = resolveStyles(styles, app.ui.themes.active);
                    if ( className === ':host' ) {
                        this.typestyle.cssRule(className, obj);
                        return;
                    }
                    obj.$displayName = className;
                    this.typestyle.style(obj);
                };

                if ( new.target.defaultCss ) {
                    if ( options.observe ) {
                        this.css = Observable.from(new.target.defaultCss);
                    } else {
                        this.css = deepmerge({}, new.target.defaultCss, { clone: true });
                    }
                    this.updateCss();

                    if ( options.observe ) {
                        Observable.observe(this.css, changes => this.updateCss());
                    }
                }
                if ( options.importStylesheets ) {
                    document.querySelectorAll(options.importSelector).forEach(linkElement => {
                        this.$fastController.element.shadowRoot.appendChild(linkElement.cloneNode());
                    });
                }
            }

            updateCss() {
                if ( this.css ) {
                    this.typestyle.reinit();
                    this.typestyle[ '_freeStyle' ]             = create();
                    this.typestyle[ '_lastFreeStyleChangeId' ] = this.typestyle[ '_freeStyle' ].changeId;
                    Object.entries(this.css).forEach(([ className, properties ]) => {
                        this.createStyle(className, properties);
                    });
                }
            }
        }

        log('Implemented styled in element', { options, Class, Styled });
        return Styled;
    };
    return fn as any;
}

export namespace styled {

    export interface Element extends FASTElement {
        css?: (Observable & CSS) | CSS;

        updateCss(): void;
    }

    export type Styles = {
        [P in keyof NestedCSSProperties]: NestedCSSProperties[P] | ((theme: Theme) => NestedCSSProperties[P])
    }

    export type CSS = Record<string, Styles>;

}


export interface NestedCSSProperties extends BaseNestedCSSProperties {
    $displayName?: string;
}

export type StyleFunction = (className: string, obj: styled.Styles) => void
