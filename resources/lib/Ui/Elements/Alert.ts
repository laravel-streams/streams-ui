import { attr, ComposableStyles, css, CSSDirective, cssPartial, FASTElement, html } from '@microsoft/fast-element';
import { element } from '../Support/decorators';
import classNames from 'classnames';

const theme = {
    alert: {
        success: {
            background: 'green',
            color     : 'black',
        },
    },
};

function myCssPartial(strings: TemplateStringsArray, ...values: (ComposableStyles | CSSDirective)[]): CSSDirective{
    let str=strings.filter(line => !line.includes('*{') || !line.includes('}')).join("\n")
    return cssPartial`${str}`;
}

function bla(color: any) {
    // noinspection CssInvalidPropertyValue
    return myCssPartial`
*{
    color: ${color};
 }
`;
}

const styles   = css`
    .alert-success {
        background: var(--ui-alert-success-background, ${theme.alert.success.background});
        //color: var(--ui-alert-success-color, black);
        ${bla('red')}
    }

    .alert-error {
        background: var(--ui-alert-error-background, red);
        color: var(--ui-alert-error-color, black);
    }

    .alert-warning {
        background: var(--ui-alert-warning-background, yellow);
        color: var(--ui-alert-warning-color, black);
    }

    .alert-info {
        background: var(--ui-alert-info-background, dodgerblue);
        color: var(--ui-alert-info-color, black);
    }
`;
const template = html<Alert>`
    <div class="${x => x.getClasses()}">
        <slot></slot>
    </div>
`;


@element('ui-alert', { template, styles })
export class Alert extends FASTElement {
    @attr type: string;


    types: string[] = [ 'success', 'error', 'warning', 'info' ];

    getClasses() {
        return classNames({
            alert                   : true,
            [ `alert-${this.type}` ]: true,
        });
    }
}
