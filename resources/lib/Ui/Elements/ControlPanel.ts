import { html, LitElement } from 'lit';
import { property } from 'lit/decorators.js';
import { element } from '../Support/decorators';


@element('ui-control-panel')
export class ControlPanel extends LitElement {
    @property({ type: String }) brand_mode: string;


    render() {
        return html`
            <div class="o-cp">
                <slot name="sidebar"></slot>
                <div class="o-cp__main">
                    <slot></slot>
                </div>
            </div>
        `;
    }
}
