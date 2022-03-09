import { attr, FASTElement, html, observable, slotted } from '@microsoft/fast-element';
import { element } from '../../Support/decorators';


const template = html<ControlPanel>`
    <div class="o-cp">
        <slot name="sidebar" ${slotted('sidebar')}></slot>
        <div class="o-cp__main">
            <slot></slot>
        </div>
    </div>
`;

@element('ui-cp', { template })
export class ControlPanel extends FASTElement {
    @attr brand_mode: string;
    @observable sidebar: HTMLElement[];


    sidebarChanged() {

        console.log('sidebarChanged', this, this.sidebar);
        if ( this.sidebar.length ) {
            if ( !this.sidebar[ 0 ].classList.contains('o-cp__sidebar') ) {
                this.sidebar[ 0 ].classList.add('o-cp__sidebar');
            }
        }
    }
}
