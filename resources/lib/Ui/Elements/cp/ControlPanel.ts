import { attr, css, ExecutionContext, FASTElement, html, observable, slotted } from '@microsoft/fast-element';
import { element } from '../../Support/decorators';

import { color } from 'csx';


const styles = css`
    :host {
        display: flex;
        height: 100vh;
        width: 100%;
        margin: 0;
        color: var(--ui-font-color, ${color('#000000').lighten(0.1, true).toHexString()});
        background-color: var(--ui-background-color, white);
    }

    .content {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .main {
        padding: 5px;
        flex-grow: 1;
    }
`

const template = html<ControlPanel>`
    <slot name="sidebar" ${slotted('sidebar')}></slot>
    <div class="content">
        <slot name="topbar" ${slotted('topbar')}></slot>
        <div class="main">
            <slot></slot>
        </div>
    </div>
`;

@element('ui-cp', { template, styles })
export class ControlPanel extends FASTElement {
    @attr brand_mode: string;
    @observable sidebar: HTMLElement[];
    @observable topbar: HTMLElement[];
    @observable title:string

}
