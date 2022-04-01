import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const components = Array.from(document.querySelectorAll('[ui\\:id]'));

function componentWasClicked(e) {
    
    const id = e.target.getAttribute('ui:id');
    const data = JSON.parse(e.target.getAttribute('ui:data'));

    const params = new URLSearchParams(data);

    window.location = '/cp/ui/' + data.component + '?' + params;
}

components.forEach((component) => component.addEventListener('click', componentWasClicked));
