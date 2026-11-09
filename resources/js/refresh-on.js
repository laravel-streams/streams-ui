// Echo-backed refresh with polling fallback. Safe to load when Echo/Alpine are absent.
(function (window) {
    if (window.streamsRefreshOn) {
        return;
    }

    window.streamsRefreshOn = {
        mount(el, wire) {
            let config;

            try {
                config = JSON.parse(el.getAttribute('data-refresh-on') || 'null');
            } catch (e) {
                config = null;
            }

            if (!config) {
                return null;
            }

            const refresh = () => {
                if (wire && typeof wire.$refresh === 'function') {
                    wire.$refresh();
                }
            };

            const stops = [];
            const hasEcho = typeof window.Echo !== 'undefined' && window.Echo !== null && !!config.channel;

            if (hasEcho) {
                const channel = config.private
                    ? window.Echo.private(config.channel)
                    : window.Echo.channel(config.channel);

                (config.events || []).forEach((event) => channel.listen(event, refresh));

                stops.push(() => {
                    if (typeof window.Echo.leave === 'function') {
                        window.Echo.leave(config.channel);
                    }
                });
            } else if (config.poll > 0) {
                const timer = setInterval(refresh, config.poll);

                stops.push(() => clearInterval(timer));
            }

            const handle = {
                mode: hasEcho ? 'echo' : (config.poll > 0 ? 'poll' : 'none'),
                refresh,
                destroy: () => stops.forEach((stop) => stop()),
            };

            el._streamsRefreshOn = handle;

            return handle;
        },
    };
})(typeof window !== 'undefined' ? window : globalThis);
