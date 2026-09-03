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

        // Set when Escape (or programmatic dismiss) clears bulk selection so a
        // pending Livewire commit does not re-select rows in matching mode.
        _dismissedSelection: false,

        normalizeEntryKey: function (key) {
            return String(key)
        },

        init: function () {
            // Hydrate from Livewire public state / server-rendered attrs BEFORE
            // watching — Alpine selectedEntries is not durable across remorphs
            // when x-data reinits (e.g. filter changes used to rewrite x-data).
            this.hydrateSelectionFromPublicState()
            this.syncMatchingTotalFromPublicState()

            this.$watch('selectedEntries', () => {
                this.syncSelectedEntries()
                this.$nextTick(() => this.updateAllEntriesSelectedState())
            }, { deep: true })

            // Do not live-sync selectAllMatching — that remorphs the table and
            // wipes Alpine selection / matching totals. Flag is passed on mountBulkAction.

            // Capture-phase: stop the native checkbox toggle before it flips the
            // header control. Bubble-phase preventDefault is too late for inputs
            // and can leave checked inverted vs selectedEntries.
            this._onSelectAllClick = (event) => {
                if (! event.target.closest('[data-select-all-trigger]')) {
                    return
                }

                event.preventDefault()
                event.stopPropagation()
                this.toggleSelectAllEntries()
            }
            this.$el.addEventListener('click', this._onSelectAllClick, true)

            // Fail-safe: if anything still flips the header checkbox natively
            // (label activation, morph, etc.), snap it back to selection state.
            this._onSelectAllChange = (event) => {
                if (! event.target?.matches?.('[data-select-all-checkbox]')) {
                    return
                }

                event.preventDefault()
                this.syncSelectAllCheckbox()
            }
            this.$el.addEventListener('change', this._onSelectAllChange, true)

            this.$watch('selectAllMatching', () => {
                this.$nextTick(() => this.updateAllEntriesSelectedState())
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

            // Livewire remorphs update data-matching-total on this root; Alpine
            // state does not follow the attribute unless we re-read it.
            this._matchingTotalObserver = new MutationObserver(() => {
                if (! this.selectAllMatching) {
                    this.readMatchingTotalFromDom()
                    this.$nextTick(() => this.updateAllEntriesSelectedState())
                }
            })
            this._matchingTotalObserver.observe(this.$el, {
                attributes: true,
                attributeFilter: ['data-matching-total'],
            })

            const afterCommit = () => {
                if (this._dismissedSelection) {
                    this._dismissedSelection = false
                    this.syncMatchingTotalFromPublicState()
                    this.$nextTick(() => this.updateAllEntriesSelectedState())

                    return
                }

                // While matching mode is on, keep the locked filtered total —
                // remorph DOM totals can briefly be wrong or empty (→ 0).
                if (! this.selectAllMatching) {
                    this.syncMatchingTotalFromPublicState()
                }

                this.$nextTick(() => {
                    // Filter/search remorphs can reinit Alpine or leave row
                    // checkboxes stale; re-read public selection when empty.
                    this.hydrateSelectionFromPublicState({ onlyIfEmpty: true })

                    if (this.selectAllMatching) {
                        this.selectEntries(this.getAllEntries())
                    }

                    this.updateAllEntriesSelectedState()
                })
            }

            // Prefer component-scoped $wire.$hook (auto id-match + cleanup) over
            // global Livewire.hook + fragile Proxy/$wire identity compares.
            if (typeof this.$wire?.$hook === 'function') {
                this.$wire.$hook('commit', ({ succeed }) => {
                    succeed(afterCommit)
                })
            } else if (typeof Livewire !== 'undefined') {
                Livewire.hook('commit', ({ component, succeed }) => {
                    const wireComponent = this.$wire?.__instance ?? this.$wire

                    if (component !== wireComponent && component?.id !== wireComponent?.id) {
                        return
                    }

                    succeed(afterCommit)
                })
            }

            this.updateAllEntriesSelectedState()
        },

        destroy: function () {
            if (this._onEscapeKey) {
                window.removeEventListener('keydown', this._onEscapeKey)
            }

            if (this._onSelectAllClick) {
                this.$el.removeEventListener('click', this._onSelectAllClick, true)
            }

            if (this._onSelectAllChange) {
                this.$el.removeEventListener('change', this._onSelectAllChange, true)
            }

            if (this._matchingTotalObserver) {
                this._matchingTotalObserver.disconnect()
                this._matchingTotalObserver = null
            }
        },

        readMatchingTotalFromDom: function () {
            const raw = this.$el?.dataset?.matchingTotal
            const total = Number(raw)

            if (! Number.isFinite(total) || total < 0) {
                return false
            }

            // Never clobber a known matching-mode total with a transient 0.
            if (this.selectAllMatching && total === 0 && this.matchingTotalCount > 0) {
                return true
            }

            this.matchingTotalCount = total

            return true
        },

        getMatchingTotalStatePath: function () {
            const selectedPath = this.getSelectedStatePath()

            if (selectedPath.endsWith('.selected')) {
                return selectedPath.slice(0, -'.selected'.length) + '.matching_total'
            }

            return `data.tables.${this.tableName}.matching_total`
        },

        /**
         * Sync Alpine matchingTotalCount from the filtered table total.
         *
         * Outside matching-mode, prefer data-matching-total: it is rendered with
         * the same paginator as the visible rows. Livewire matching_total can lag
         * after filter/search remorphs when nested $data was last written during a
         * prior render, which left "Select all N matching" showing an unfiltered N.
         *
         * In matching-mode, prefer Livewire / the locked count and ignore transient
         * DOM zeros during remorph.
         */
        syncMatchingTotalFromPublicState: function () {
            if (! this.selectAllMatching && this.readMatchingTotalFromDom()) {
                return
            }

            const path = this.getMatchingTotalStatePath()

            if (path && this.$wire) {
                try {
                    let value = null

                    if (typeof this.$wire.get === 'function') {
                        value = this.$wire.get(path)
                    } else if (typeof this.$wire.$get === 'function') {
                        value = this.$wire.$get(path)
                    }

                    const total = Number(value)

                    if (Number.isFinite(total) && total >= 0) {
                        if (this.selectAllMatching && total === 0 && this.matchingTotalCount > 0) {
                            return
                        }

                        this.matchingTotalCount = total

                        return
                    }
                } catch (error) {
                    // fall through to DOM
                }
            }

            this.readMatchingTotalFromDom()
        },

        /**
         * Restore Alpine selection from Livewire public state (and server-rendered
         * data-* attrs). Selection must survive filter/search remorphs.
         */
        hydrateSelectionFromPublicState: function (options = {}) {
            const onlyIfEmpty = options.onlyIfEmpty === true
            const publicKeys = this.readSelectedKeysFromPublicState()
            const publicMatching = this.readSelectAllMatchingFromPublicState()

            if (publicMatching) {
                this.selectAllMatching = true
            } else if (! onlyIfEmpty && this.selectedEntries.length === 0) {
                this.selectAllMatching = false
            }

            if (publicKeys.length === 0) {
                return
            }

            if (onlyIfEmpty && this.selectedEntries.length > 0) {
                return
            }

            this.suppressSelectedSync = true
            this.selectedEntries.splice(
                0,
                this.selectedEntries.length,
                ...publicKeys.map((key) => this.normalizeEntryKey(key)),
            )
            this.$nextTick(() => {
                this.suppressSelectedSync = false
            })
        },

        readSelectedKeysFromPublicState: function () {
            const fromWire = this.readSelectedKeysFromLivewire()

            if (fromWire.length > 0) {
                return fromWire
            }

            return this.readSelectedKeysFromDomAttribute()
        },

        readSelectedKeysFromLivewire: function () {
            const path = this.getSelectedStatePath()

            if (! path || ! this.$wire) {
                return []
            }

            let value = null

            try {
                if (typeof this.$wire.get === 'function') {
                    value = this.$wire.get(path)
                } else if (typeof this.$wire.$get === 'function') {
                    value = this.$wire.$get(path)
                }
            } catch (error) {
                value = null
            }

            if (! Array.isArray(value)) {
                return []
            }

            return value
                .map((key) => this.normalizeEntryKey(key))
                .filter((key) => key !== '')
        },

        readSelectedKeysFromDomAttribute: function () {
            const raw = this.$el?.dataset?.selectedKeys

            if (! raw) {
                return []
            }

            try {
                const parsed = JSON.parse(raw)

                if (! Array.isArray(parsed)) {
                    return []
                }

                return parsed
                    .map((key) => this.normalizeEntryKey(key))
                    .filter((key) => key !== '')
            } catch (error) {
                return []
            }
        },

        readSelectAllMatchingFromPublicState: function () {
            const path = this.getSelectAllMatchingStatePath()

            if (path && this.$wire) {
                try {
                    let value = null

                    if (typeof this.$wire.get === 'function') {
                        value = this.$wire.get(path)
                    } else if (typeof this.$wire.$get === 'function') {
                        value = this.$wire.$get(path)
                    }

                    if (value === true || value === 1 || value === '1') {
                        return true
                    }

                    if (value === false || value === 0 || value === '0') {
                        return false
                    }
                } catch (error) {
                    // fall through to DOM attribute
                }
            }

            return this.$el?.dataset?.selectAllMatching === '1'
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
            this.persistSelectAllMatching(true)

            // Prefer the already-synced filtered total (DOM / prior commit). A
            // Livewire count round-trip remorphs the table and can wipe Alpine
            // matching mode before Archive runs.
            if (fallbackTotal > this.selectedEntries.length) {
                return
            }

            this.isLoading = true

            try {
                if (typeof this.$wire.getFilteredTableRecordsCount === 'function') {
                    const total = Number(await this.$wire.getFilteredTableRecordsCount(this.tableName))

                    if (Number.isFinite(total) && total > 0) {
                        this.matchingTotalCount = total
                    } else if (fallbackTotal > 0) {
                        this.matchingTotalCount = fallbackTotal
                    }
                } else {
                    this.syncMatchingTotalFromPublicState()
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
            this.persistSelectAllMatching(false)
        },

        persistSelectAllMatching: function (value) {
            const path = this.getSelectAllMatchingStatePath()

            if (! path || ! this.$wire || typeof this.$wire.set !== 'function') {
                return
            }

            // live=false updates public state without a remorph.
            try {
                this.$wire.set(path, !! value, false)
            } catch (error) {
                // non-fatal — mountBulkAction still passes the Alpine flag
            }
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

            this.dismissBulkSelection()
        },

        dismissBulkSelection: function () {
            this._dismissedSelection = true
            this.clearSelectAllMatching()
            this.deselectAllEntries({ sync: false })
            this.updateAllEntriesSelectedState()

            if (typeof this.$wire?.deselectAllTableRecords === 'function') {
                this.$wire.deselectAllTableRecords()
            }
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

        /**
         * Header select-all is fully controlled from Alpine selection state.
         * Never trust the native checked flag — wire:ignore.self can preserve a
         * stale DOM value across Livewire morphs and invert the control.
         */
        syncSelectAllCheckbox: function () {
            const checkbox = this.$el.querySelector('[data-select-all-checkbox]')

            if (! checkbox) {
                return
            }

            const pageKeys = this.getAllEntries()
            const allSelected = pageKeys.length > 0 && this.areEntriesSelected(pageKeys)
            const anySelected = this.selectedEntries.length > 0
            const checked = this.selectAllMatching || allSelected
            const indeterminate = ! checked && anySelected

            checkbox.checked = checked
            checkbox.indeterminate = indeterminate

            if (checked) {
                checkbox.setAttribute('checked', 'checked')
            } else {
                checkbox.removeAttribute('checked')
            }

            checkbox.setAttribute('aria-checked', indeterminate ? 'mixed' : (checked ? 'true' : 'false'))
        },

        updateAllEntriesSelectedState: function () {
            const pageKeys = this.getAllEntries()
            const allSelected = pageKeys.length > 0 && this.areEntriesSelected(pageKeys)

            this.allEntriesSelected = allSelected || this.selectAllMatching
            this.syncSelectAllCheckbox()
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
                false,
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
            const matching = !! this.selectAllMatching

            this.$wire.mountTableBulkAction(
                name,
                [...this.selectedEntries],
                this.tableName,
                matching,
            );
        },

        /**
         * Selection
         */
        toggleSelectAllEntries: function () {
            const keys = this.getAllEntries()
            const allSelected = keys.length > 0 && this.areEntriesSelected(keys)
            const anySelected = this.selectedEntries.length > 0 || this.selectAllMatching

            // Decide from selection state only — never from checkbox.checked.
            // Indeterminate (some selected) clears instead of selecting the rest:
            // after filters expand the page, the header looks "off" while rows
            // remain checked; clicking must dismiss, not silently select more.
            if (allSelected || this.selectAllMatching || anySelected) {
                this.clearSelectAllMatching()
                this.deselectAllEntries()
            } else if (keys.length > 0) {
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
                    this.updateAllEntriesSelectedState()
                })

                return
            }

            this.updateAllEntriesSelectedState()
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
