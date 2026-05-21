// import Sortable from 'sortablejs';

function table(tableName = 'default', initialSelectedEntries = [], selectedStatePath = null) {
    return {
        
        isLoading: false,

        tableName,
        selectedEntries: initialSelectedEntries,
        selectedStatePath,

        isDraggable: true,
        draggedIndex: null,
        droppedIndex: null,

        shouldCheckUniqueSelection: true,

        bulkMenuOpen: false,

        init: function () {

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

            this.$watch('selectedEntries', () => {

                if (!this.shouldCheckUniqueSelection) {

                    this.shouldCheckUniqueSelection = true

                    return
                }

                this.selectedEntries = [...new Set(this.selectedEntries)]
                this.syncSelectedEntries();

                this.shouldCheckUniqueSelection = false
            }, { deep: true });
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

        mountBulkAction: function (name) {
            this.syncSelectedEntries();

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

            if (this.areEntriesSelected(keys)) {
                
                this.deselectEntries(keys)

                return
            }

            this.selectEntries(keys)

        },

        getAllEntries: function () {
            
            const keys = []

            for (let checkbox of this.$root.getElementsByClassName(
                'ui-table-entry-checkbox',
            )) {
                keys.push(checkbox.value)
            }

            return keys
        },

        selectEntries: function (keys) {
            let selected = [...this.selectedEntries]

            for (let key of keys) {

                if (selected.includes(key)) {
                    continue
                }

                selected.push(key)
            }

            this.selectedEntries = selected
        },

        deselectEntries: function (keys) {
            this.selectedEntries = this.selectedEntries.filter(
                (key) => ! keys.includes(key),
            )
        },

        selectAllEntries: async function () {
            this.isLoading = true

            this.selectedEntries =
                await this.$wire.getAllSelectableTableEntryKeys()

            this.isLoading = false
        },

        deselectAllEntries: function () {
            this.selectedEntries = []
        },

        isEntrySelected: function (key) {
            return this.selectedEntries.includes(key)
        },

        toggleEntry: function (key) {
            if (this.isEntrySelected(key)) {
                this.deselectEntries([key])
            } else {
                this.selectEntries([key])
            }
            
            this.syncSelectedEntries();
        },

        areEntriesSelected: function (keys) {
            return keys.every((key) => this.isEntrySelected(key))
        }
        
    }
}
