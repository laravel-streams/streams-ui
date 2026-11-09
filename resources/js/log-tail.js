// Append-only log rendering. Existing line nodes are never re-rendered.
(function (window) {
    if (window.streamsLogTail) {
        return;
    }

    window.streamsLogTail = {
        // Apply the server state on `el` (data-lines JSON, data-offset, data-cap) to `view`.
        sync(el, view, state) {
            const lines = JSON.parse(el.getAttribute('data-lines') || '[]');
            const offset = parseInt(el.getAttribute('data-offset') || '0', 10);
            const cap = parseInt(el.getAttribute('data-cap') || '500', 10);

            // The server window moved past what we have: drop old nodes, start over.
            const start = Math.max(state.next, offset);

            lines.forEach((line, i) => {
                const abs = offset + i;

                if (abs < start) {
                    return;
                }

                const node = view.ownerDocument.createElement('div');
                node.textContent = line;
                view.appendChild(node);
                state.next = abs + 1;
            });

            while (view.childNodes.length > cap) {
                view.removeChild(view.firstChild);
            }

            if (state.pinned) {
                view.scrollTop = view.scrollHeight;
            }

            return state;
        },

        mount(el) {
            const view = el.querySelector('[data-log-view]');
            const state = { next: 0, pinned: true };

            // Server markup already contains the initial lines; rebuild via sync once.
            while (view.firstChild) {
                view.removeChild(view.firstChild);
            }

            view.addEventListener('scroll', () => {
                state.pinned = view.scrollTop + view.clientHeight >= view.scrollHeight - 4;
            });

            this.sync(el, view, state);

            const observer = new MutationObserver(() => this.sync(el, view, state));
            observer.observe(el, { attributes: true, attributeFilter: ['data-lines', 'data-offset'] });

            return { state, destroy: () => observer.disconnect() };
        },
    };
})(typeof window !== 'undefined' ? window : globalThis);
