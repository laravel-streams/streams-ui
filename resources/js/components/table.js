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

        // Select every row matching current filters/search (not just this page).
        selectAllMatching: false,
        matchingTotalCount: 0,

        // When the server clears selection (e.g. after a bulk action), skip the
        // selectedEntries → $wire.set sync. That extra Livewire round-trip remorphs
        // the page and tears down notification toasts that only exist via View::share
        // from the action response.
        suppressSelectedSync: false,

        normalizeEntryKey: function (key) {
            return String(key)
        },

        init: function () {
            this.readMatchingTotalFromDom()

            this.$watch('selectedEntries', () => {
                this.syncSelectedEntries()
                this.$nextTick(() => this.updateAllEntriesSelectedState())
            }, { deep: true })

            // Do not live-sync selectAllMatching — that remorphs the table and
            // wipes Alpine selection / matching totals. Flag is passed on mountBulkAction.

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
                        // While matching mode is on, keep the locked filtered total —
                        // remorph DOM totals can briefly be wrong or empty (→ 0).
                        if (! this.selectAllMatching) {
                            this.readMatchingTotalFromDom()
                        }

                        this.$nextTick(() => {
                            if (this.selectAllMatching) {
                                this.selectEntries(this.getAllEntries())
                            }

                            this.updateAllEntriesSelectedState()
                        })
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

        readMatchingTotalFromDom: function () {
            const raw = this.$el?.dataset?.matchingTotal
            const total = Number(raw)

            if (! Number.isFinite(total) || total < 0) {
                return
            }

            // Never clobber a known matching-mode total with a transient 0.
            if (this.selectAllMatching && total === 0 && this.matchingTotalCount > 0) {
                return
            }

            this.matchingTotalCount = total
        },

        selectedCount: function () {
            if (this.selectAllMatching) {
                return this.matchingTotalCount > 0
                    ? this.matchingTotalCount
                    : this.selectedEntries.length
            }

            return this.selectedEntries.length
        },

        canSelectAllMatching: function () {
            return ! this.selectAllMatching
                && this.allEntriesSelected
                && this.matchingTotalCount > this.selectedEntries.length
                && this.selectedEntries.length > 0
        },

        enableSelectAllMatching: async function () {
            if (this.selectAllMatching) {
                return
            }

            if (! this.allEntriesSelected || this.matchingTotalCount <= this.selectedEntries.length) {
                return
            }

            const fallbackTotal = this.matchingTotalCount

            this.selectAllMatching = true
            this.isLoading = true

            try {
                if (typeof this.$wire.getFilteredTableRecordsCount === 'function') {
                    const total = Number(await this.$wire.getFilteredTableRecordsCount(this.tableName))

                    if (Number.isFinite(total) && total > 0) {
                        this.matchingTotalCount = total
                    } else if (fallbackTotal > 0) {
                        this.matchingTotalCount = fallbackTotal
                    }
                }
            } catch (error) {
                if (fallbackTotal > 0) {
                    this.matchingTotalCount = fallbackTotal
                }
            } finally {
                this.isLoading = false
            }
        },

        clearSelectAllMatching: function () {
            if (! this.selectAllMatching) {
                return
            }

            this.selectAllMatching = false
        },

        handleEscapeKey: function (event) {
            if (event.key !== 'Escape') {
                return
            }

            if (this.selectedEntries.length === 0 && ! this.selectAllMatching) {
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

            if (this.selectAllMatching || selected) {
                checkbox.checked = true
                checkbox.indeterminate = false

                return
            }

            checkbox.checked = false
            checkbox.indeterminate = this.selectedEntries.length > 0
        },

        updateAllEntriesSelectedState: function () {
            const selected = this.isAllEntriesSelected()

            this.allEntriesSelected = selected || this.selectAllMatching
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

        getSelectAllMatchingStatePath: function () {
            const selectedPath = this.getSelectedStatePath()

            if (selectedPath.endsWith('.selected')) {
                return selectedPath.slice(0, -'.selected'.length) + '.select_all_matching'
            }

            return `data.tables.${this.tableName}.select_all_matching`
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

        syncSelectAllMatching: function () {
            // Intentionally no-op for live sync. Matching mode is Alpine-local until
            // mountBulkAction passes selectAllMatching to Livewire.
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
                this.selectAllMatching,
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
                this.clearSelectAllMatching()
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
            if (this.selectAllMatching) {
                this.clearSelectAllMatching()
            }

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

            this.selectAllMatching = false
            this.selectedEntries.splice(0, this.selectedEntries.length)

            if (! sync) {
                this.$nextTick(() => {
                    this.suppressSelectedSync = false
                })
            }
        },

        isEntrySelected: function (key) {
            const normalizedKey = this.normalizeEntryKey(key)

            return this.selectedEntries.some(
                (entry) => this.normalizeEntryKey(entry) === normalizedKey,
            )
        },

        areEntriesSelected: function (keys) {
            if (keys.length === 0) {
                return false
            }

            return keys.every((key) => this.isEntrySelected(key))
        }
        
    }
}
