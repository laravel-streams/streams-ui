import { FASTElement, html } from '@microsoft/fast-element';
import { element, styled } from '../../Support';

const template = html`
    <div>
        <slot name="start"></slot>
        <slot></slot>
    </div>
    <div class="space"></div>
    <div>
        <button @click=${(x, c) => x.handleButtonClick(c)} type="button">Test</button>
        <slot name="end"></slot>
    </div>
`;

export interface Toolbar extends styled.Element {}

@element('ui-toolbar', { template })
@styled({ observe: true, importStylesheets:true })
export class Toolbar extends FASTElement {
    static defaultCss: styled.CSS = {
        ':host': {
            height       : t => t.ui_toolbar.height,
            background   : t => t.ui_toolbar.background,
            color        : t => t.ui_toolbar.color,
            display      : 'flex',
            flexDirection: 'row',
        },
        space  : {
            flexGrow: 1,
        },
    };

    handleButtonClick(e) {
        this.css.space.flexGrow = Math.round(Math.random());
        console.log('clicked', this, this.css.space.flexGrow);
    }

}
