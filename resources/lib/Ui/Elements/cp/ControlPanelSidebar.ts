import { attr, css, ExecutionContext, FASTElement, html, observable, slotted } from '@microsoft/fast-element';
import { element } from '../../Support/decorators';


const styles = css`
    :host {
       width: var(--ui-cp-sidebar-width, 200px)
    }
`

const template = html<ControlPanelSidebar>`
    <div class="c-sidebar">
    <slot></slot>
    </div>
`;

@element('ui-cp-sidebar', { template, styles })
export class ControlPanelSidebar extends FASTElement {
}
