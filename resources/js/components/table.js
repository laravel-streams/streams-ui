function table() {
    return {
        
        isLoading: false,

        selectedEntries: [],

        shouldCheckUniqueSelection: true,

        init: function () {
            
            this.$wire.$on('deselectAllTableEntries', () =>
                this.deselectAllEntries(),
            )

            this.$watch('selectedEntries', () => {
                
                if (!this.shouldCheckUniqueSelection) {
                
                    this.shouldCheckUniqueSelection = true

                    return
                }

                this.selectedEntries = [...new Set(this.selectedEntries)]

                this.shouldCheckUniqueSelection = false
            })
        },

        mountBulkAction: function (name) {
            this.$wire.set('selectedTableEntries', this.selectedEntries, false)
            this.$wire.mountTableBulkAction(name)
        },

        toggleSelectAllEntries: function () {
            
            const keys = this.getAllEntries()

            if (this.areEntriesSelected(keys)) {
                
                this.deselectEntries(keys)

                this.$wire.set('selectedTableEntries', this.selectedEntries, false);

                return
            }

            this.selectEntries(keys)

            this.$wire.set('selectedTableEntries', this.selectedEntries, false);
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
            for (let key of keys) {
                
                if (this.isEntrySelected(key)) {
                    continue
                }

                this.selectedEntries.push(key)
            }
        },

        deselectEntries: function (keys) {
            for (let key of keys) {
                
                let index = this.selectedEntries.indexOf(key)

                if (index === -1) {
                    continue
                }

                this.selectedEntries.splice(index, 1)
            }
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

        areEntriesSelected: function (keys) {
            return keys.every((key) => this.isEntrySelected(key))
        },
    }
}
