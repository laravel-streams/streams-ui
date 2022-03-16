import { attr, css, FASTElement, html, observable, slotted } from '@microsoft/fast-element';
import { element } from '../../Support';
import { theme } from '../../Theme';


const styles = css`
    :host {
        display: flex;
        height: 100vh;
        width: 100%;
        margin: 0;
        color: ${theme.ui.color};
        background-color: ${theme.ui.background_color};
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
`;

const template = html<ControlPanel>`
    <slot name="sidebar" ${slotted('sidebar')}></slot>
    <div class="content">
        <slot name="header" ${slotted('header')}></slot>
        <div class="main">
            <slot></slot>
        </div>
    </div>
`;

@element('ui-cp', { template, styles })
export class ControlPanel extends FASTElement {
    @attr brand_mode: string;
    @observable sidebar: HTMLElement[];
    @observable header: HTMLElement[];
    @observable title: string;

}
