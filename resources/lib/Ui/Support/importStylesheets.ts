import { FASTElement } from '@microsoft/fast-element';

export const importStylesheets = (element: FASTElement) => {
    document.querySelectorAll('link[data-element-import]').forEach(linkElement => {
        element.$fastController.element.shadowRoot.appendChild(linkElement.cloneNode());
    });
};
