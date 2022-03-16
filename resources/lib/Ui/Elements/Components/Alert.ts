import { attr, css, FASTElement, html, volatile, when } from '@microsoft/fast-element';
import { element } from '../../Support';
import classNames from 'classnames';
import { darken, theme, variables } from '../../Theme';

const styles   = css`
    .alert {
        padding: 10px 10px;
        margin: 5px;
        border: 1px solid transparent;
    }

    .label {
        font-size: ${theme.ui_alert.label_size};
        margin-bottom: 0.5em;
    }

    .message {
        font-size: ${theme.ui_alert.message_size};
        margin: 0;
    }

    .alert--success {
        background: ${theme.ui_alert.success_background};
        color: ${theme.ui_alert.success_color};
        border-color: ${darken(variables.ui_alert_success_background, 0.1)};
    }

    .alert--danger, .alert--error {
        background: ${theme.ui_alert.danger_background};
        color: ${theme.ui_alert.danger_color};
        border-color: ${darken(variables.ui_alert_danger_background, 0.1)};
    }

    .alert--warning {
        background: ${theme.ui_alert.warning_background};
        color: ${theme.ui_alert.warning_color};
        border-color: ${darken(variables.ui_alert_warning_background, 0.1)};
    }

    .alert--info {
        background: ${theme.ui_alert.info_background};
        color: ${theme.ui_alert.info_color};
        border-color: ${darken(variables.ui_alert_info_background, 0.1)};
    }
`;
const template = html<Alert>`
    <div class="${x => x.classes}">
        <slot name="content">
            <slot name="label">
                ${when(x => x.label, () => html`
                    <div class="label">${x => x.label}</div>`)}
            </slot>
            <p class="message">
                <slot></slot>
            </p>
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
