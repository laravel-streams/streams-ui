import { css, FASTElement, html } from '@microsoft/fast-element';
import { element } from '../../Support/decorators';


const styles = css`
    .o-cp__topbar {
        width: 20%;
    }
`;

const template = html<ControlPanelTopBar>`
    <div class="c-topbar">
        <slot></slot>
    </div>
`;

@element('ui-cp-top-bar', { template, styles })
export class ControlPanelTopBar extends FASTElement {

}
