// import Sortable from 'sortablejs';

function table(tableName = 'default', selectedStatePath = null) {
    return {
        
        isLoading: false,

        tableName,
        selectedEntries: [],
        selectedStatePath,

        isDraggable: true,
        draggedIndex: null,
        droppedIndex: null,

        allEntriesSelected: false,

        // When the server clears selection (e.g. after a bulk action), skip the
        // selectedEntries → $wire.set sync. That extra Livewire round-trip remorphs
        // the page and tears down notification toasts that only exist via View::share
        // from the action response.
        suppressSelectedSync: false,

        normalizeEntryKey: function (key) {
            return String(key)
        },

        init: function () {
            this.$watch('selectedEntries', () => {
                this.syncSelectedEntries()
                this.$nextTick(() => this.updateAllEntriesSelectedState())
            }, { deep: true })

            this.$el.addEventListener('click', (event) => {
                if (event.target.closest('[data-select-all-trigger]')) {
                    event.preventDefault()
                    this.toggleSelectAllEntries()
                }
            })

            if (typeof Sortable !== 'undefined') {
                
                const sortable = new Sortable(this.$refs.table.querySelector('table.min-w-full tbody'), {
                    animation: 150,
                    draggable: 'tr',
                    handle: '.drag-handle',
                    dataIdAttr: 'data-key',
                    dragClass: 'sortable-drag',
                    ghostClass: 'sortable-ghost',
                    onEnd: (evt) => {
                        
                        let sortedIds = Array.from(evt.target.querySelectorAll('tr'))
                            .map(row => row.getAttribute('data-key'));
    
                        console.log(sortedIds);
    
                        this.$wire.set('sortedIds', sortedIds);
                    }
                });
            }

            this.$wire.$on('deselectAllTableEntries', () =>
                this.deselectAllEntries({ sync: false }),
            );

            this._onEscapeKey = (event) => this.handleEscapeKey(event)
            window.addEventListener('keydown', this._onEscapeKey)

            if (typeof Livewire !== 'undefined') {
                Livewire.hook('commit', ({ component, succeed }) => {
                    if (component !== this.$wire) {
                        return
                    }

                    succeed(() => {
                        this.$nextTick(() => this.updateAllEntriesSelectedState())
                    })
                })
            }

            this.updateAllEntriesSelectedState()
        },

        destroy: function () {
            if (this._onEscapeKey) {
                window.removeEventListener('keydown', this._onEscapeKey)
            }
        },

        handleEscapeKey: function (event) {
            if (event.key !== 'Escape') {
                return
            }

            if (this.selectedEntries.length === 0) {
                return
            }

            // Let open modals / dropdowns consume Escape first.
            if (this.hasOpenOverlay()) {
                return
            }

            this.deselectAllEntries()
        },

        hasOpenOverlay: function () {
            if (document.querySelector('dialog[open]')) {
                return true
            }

            // Streams UI modals teleport a fixed overlay to body while open.
            for (const el of document.querySelectorAll('body > div.fixed.inset-0')) {
                if (! this.isElementVisible(el)) {
                    continue
                }

                if (
                    el.querySelector('.ui-modal-content') ||
                    el.querySelector('.ui-modal-close-btn') ||
                    el.querySelector('[x-ref="modalContainer"]')
                ) {
                    return true
                }
            }

            // Filters, action menus, user menu, etc. use Alpine `open` + x-show.
            for (const el of document.querySelectorAll('[x-show="open"]')) {
                if (this.isElementVisible(el)) {
                    return true
                }
            }

            return false
        },

        isElementVisible: function (el) {
            if (! (el instanceof Element)) {
                return false
            }

            if (el.hasAttribute('hidden') || el.getAttribute('aria-hidden') === 'true') {
                return false
            }

            const style = window.getComputedStyle(el)

            if (style.display === 'none' || style.visibility === 'hidden') {
                return false
            }

            return el.getClientRects().length > 0
        },

        syncSelectAllCheckbox: function (selected) {
            const checkbox = this.$el.querySelector('[data-select-all-checkbox]')

            if (! checkbox) {
                return
            }

            checkbox.checked = selected
        },

        updateAllEntriesSelectedState: function () {
            const selected = this.isAllEntriesSelected()

            this.allEntriesSelected = selected
            this.syncSelectAllCheckbox(selected)
        },

        getSelectedStatePath: function () {
            // Empty string must not win over the fallback (`??` only treats null/undefined).
            // A blank or leading-dot path makes Livewire try to set public property [$].
            if (typeof this.selectedStatePath === 'string' && this.selectedStatePath !== '' && ! this.selectedStatePath.startsWith('.')) {
                return this.selectedStatePath
            }

            return `data.tables.${this.tableName}.selected`
        },

        syncSelectedEntries: function () {
            if (this.suppressSelectedSync) {
                return
            }

            const path = this.getSelectedStatePath()

            if (! path || path === '' || path.startsWith('.')) {
                return
            }

            this.$wire.set(
                path,
                [...this.selectedEntries],
                true,
            );
        },

        isAllEntriesSelected: function () {
            const keys = this.getAllEntries()

            if (keys.length === 0) {
                return false
            }

            return keys.every((key) => this.isEntrySelected(key))
        },

        mountBulkAction: function (name) {
            this.$wire.mountTableBulkAction(
                name,
                [...this.selectedEntries],
                this.tableName,
            );
        },

        /**
         * Selection
         */
        toggleSelectAllEntries: function () {
            const keys = this.getAllEntries()

            if (keys.length === 0) {
                return
            }

            if (this.areEntriesSelected(keys)) {
                this.deselectEntries(keys)
            } else {
                this.selectEntries(keys)
            }

            this.updateAllEntriesSelectedState()
        },

        getAllEntries: function () {
            return Array.from(
                this.$el.querySelectorAll('.ui-table-entry-checkbox'),
                (checkbox) => checkbox.value,
            )
        },

        selectEntries: function (keys) {
            for (let key of keys) {
                const normalizedKey = this.normalizeEntryKey(key)

                if (this.isEntrySelected(normalizedKey)) {
                    continue
                }

                this.selectedEntries.push(normalizedKey)
            }
        },

        deselectEntries: function (keys) {
            const normalizedKeys = new Set(keys.map((key) => this.normalizeEntryKey(key)))

            for (let index = this.selectedEntries.length - 1; index >= 0; index--) {
                if (normalizedKeys.has(this.normalizeEntryKey(this.selectedEntries[index]))) {
                    this.selectedEntries.splice(index, 1)
                }
            }
        },

        selectAllEntries: async function () {
            this.isLoading = true

            this.selectedEntries.splice(0, this.selectedEntries.length)

            for (let key of await this.$wire.getAllSelectableTableEntryKeys()) {
                this.selectedEntries.push(this.normalizeEntryKey(key))
            }

            this.isLoading = false
        },

        deselectAllEntries: function (options = {}) {
            const sync = options.sync !== false

            if (! sync) {
                this.suppressSelectedSync = true
            }

            this.selectedEntries.splice(0, this.selectedEntries.length)

            if (! sync) {
                this.$nextTick(() => {
                    this.suppressSelectedSync = false
                })
            }
        },

        isEntrySelected: function (key) {
            return this.selectedEntries.includes(this.normalizeEntryKey(key))
        },

        areEntriesSelected: function (keys) {
            if (keys.length === 0) {
                return false
            }

            return keys.every((key) => this.isEntrySelected(key))
        }
        
    }
}
