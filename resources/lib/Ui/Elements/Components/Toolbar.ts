import { css, FASTElement, html } from '@microsoft/fast-element';
import { element } from '../../Support/decorators';
import { theme } from '../../Theme';


const styles   = css`
    :host {
        height: ${theme.ui_toolbar.height};
        background: ${theme.ui_toolbar.background};
        color: ${theme.ui_toolbar.color};
        display: flex;
        flex-direction: row;
    }
    .space {
        flex-grow: 1;
    }
`;
const template = html`
    <div>
        <slot name="start"></slot>
        <slot></slot>
    </div>
    <div class="space"></div>
    <div>
        <slot name="end"></slot>
    </div>
`;

@element('ui-toolbar', { template, styles })
export class Toolbar extends FASTElement {


}
