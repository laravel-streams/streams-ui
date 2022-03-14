import { css, FASTElement, html } from '@microsoft/fast-element';
import { element } from '../../Support/decorators';
import { theme } from '../../Theme';


const styles = css`
    :host {
        width: ${theme.ui_cp_sidebar.width};
        background: ${theme.ui_cp_sidebar.background};
        color: ${theme.ui_cp_sidebar.color};
    }
`;

const template = html<ControlPanelSidebar>`
    <slot></slot>
`;

@element('ui-cp-sidebar', { template, styles })
export class ControlPanelSidebar extends FASTElement {
}
