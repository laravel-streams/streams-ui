import Alpine from 'alpinejs';
import morphdom from 'morphdom';

window.Alpine = Alpine;

Alpine.start();

const components = Array.from(document.querySelectorAll('[ui\\:id]'));

async function componentWasClicked(e) {
    
    const id = e.target.getAttribute('ui:id');
    const data = JSON.parse(e.target.getAttribute('ui:data'));

    delete data.attributes;

    data.text = 'TESTED';

    const params = new URLSearchParams(data);

    const response = await fetch('/cp/ui/' + data.component + '?' + params);

    morphdom(e.target, await response.text());
}

components.forEach((component) => component.addEventListener('click', componentWasClicked));
