import { css, FASTElement, html } from '@microsoft/fast-element';
import { element } from '../../Support';
import { theme } from '../../Theme';


const styles = css`
    :host {
        width: 100%;
        height: ${theme.ui_cp_header.height};
        background: ${theme.ui_cp_header.background};
        color: ${theme.ui_cp_header.color};
    }
`;

const template = html<ControlPanelHeader>`
    <slot></slot>
`;

@element('ui-cp-header', { template, styles })
export class ControlPanelHeader extends FASTElement {

}
