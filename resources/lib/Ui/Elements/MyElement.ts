import { LitElement, html } from 'lit';
import {  property } from 'lit/decorators.js';
import { element } from '../Support/decorators';


@element('my-element')
export class MyElement extends LitElement {
    @property()
    render() {
        return html`
      <div>Hello from MyElement!</div>
    `;
    }
}


