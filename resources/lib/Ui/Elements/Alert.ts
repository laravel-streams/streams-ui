import { css, html, LitElement } from 'lit';
import { property } from 'lit/decorators.js';
import { classMap } from 'lit/directives/class-map.js';
import { element } from '../Support/decorators';


const styles = css`
    .alert-success {
        background: var(--ui-alert-success-background, green);
        color: var(--ui-alert-success-color, black);
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

@element('ui-alert')
export class Alert extends LitElement {
    static styles = styles;
    @property({ type: String }) type: string;
    types: string[] = [ 'success', 'error', 'warning', 'info' ];

    render() {
        return html`
            <div class="${classMap(this.getClasses())}">
                <slot></slot>
            </div>
        `;
    }

    getClasses() {
        return {
            alert                   : true,
            [ `alert-${this.type}` ]: true,
        };
    }
}
