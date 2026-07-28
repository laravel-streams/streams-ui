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
                this.deselectAllEntries(),
            );

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
            return this.selectedStatePath ?? `data.tables.${this.tableName}.selected`
        },

        syncSelectedEntries: function () {
            this.$wire.set(
                this.getSelectedStatePath(),
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

        deselectAllEntries: function () {
            this.selectedEntries.splice(0, this.selectedEntries.length)
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
