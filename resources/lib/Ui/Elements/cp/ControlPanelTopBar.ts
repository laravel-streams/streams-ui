import { css, FASTElement, html } from '@microsoft/fast-element';
import { element } from '../../Support/decorators';


const styles = css`
    :host {
        width: 100%;
        height: 50px;

    }
`;

const template = html<ControlPanelTopBar>`
    <slot></slot>
`;

@element('ui-cp-topbar', { template, styles })
export class ControlPanelTopBar extends FASTElement {

}
