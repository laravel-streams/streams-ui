import { attr, css, FASTElement, html, volatile, when } from '@microsoft/fast-element';
import { element } from '../../Support/decorators';
import classNames from 'classnames';
import { theme } from '../../Theme';
//
// const theme = {
//     alert: {
//         success: {
//             background: 'green',
//             color     : 'black',
//         },
//     },
// };
//
// function myCssPartial(strings: TemplateStringsArray, ...values: (ComposableStyles | CSSDirective)[]): CSSDirective{
//     let str=strings.filter(line => !line.includes('*{') || !line.includes('}')).join("\n")
//     return cssPartial`${str}`;
// }
//
// function bla(color: any) {
//     // noinspection CssInvalidPropertyValue
//     return myCssPartial`
// *{
//     color: ${color};
//  }
// `;
// }

const styles   = css`
    .alert {
        padding: 5px;
    }

    .label {
        font-size: ${theme.ui_alert.label_size};
    }

    .message {
        font-size: ${theme.ui_alert.message_size};
    }

    .alert--success {
        background: ${theme.ui_alert.success_background};
        color: ${theme.ui_alert.success_color};
    }

    .alert--danger, .alert--error {
        background: ${theme.ui_alert.danger_background};
        color: ${theme.ui_alert.danger_color};
    }

    .alert--warning {
        background: ${theme.ui_alert.warning_background};
        color: ${theme.ui_alert.warning_color};
    }

    .alert--info {
        background: ${theme.ui_alert.info_background};
        color: ${theme.ui_alert.info_color};
    }
`;
const template = html<Alert>`
    <div class="${x => x.classes}">
        <slot name="content">
            <slot name="label">
                ${when(x => x.label, () => html`<span class="label">${x => x.label}</span>`)}
            </slot>
            <span class="message">
                <slot></slot>
            </span>
        </slot>
    </div>
`;


@element('ui-alert', { template, styles })
export class Alert extends FASTElement {
    @attr label?: string;
    @attr type: string;
    types: string[] = [ 'success', 'error', 'warning', 'info', 'error' ];

    @volatile
    get classes() {
        return classNames({
            alert                    : true,
            [ `alert--${this.type}` ]: true,
        });
    }
}
