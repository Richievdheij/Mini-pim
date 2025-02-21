import { ref, computed, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

/**
 * Composable function to manage entity tables.
 * @param {String} entityName - The name of the entity to manage.
 * @returns {Object} - Reactive references and functions to manage the entity table.
 */
export default function useEntityTable(entityName) {
    // Reactive references for modal visibility
    const showCreateModal = ref(false);
    const showEditModal = ref(false);
    const showDeleteModal = ref(false);
    const itemToEdit = ref(null);
    const itemToDelete = ref(null);
    const searchQuery = ref("");

    // Get the current page and initialize items and types
    const page = usePage();
    const items = ref(page?.props?.[entityName] || []);
    const types = ref(page?.props?.types || []);

    // Configuration for sorting
    const sortConfig = ref({
        column: null,
        direction: "none",
    });

    /**
     * Opens a modal of the specified type.
     * @param {String} modalType - The type of modal to open ('create', 'edit', 'delete').
     * @param {Object|null} item - The item to edit or delete (optional).
     */
    function openModal(modalType, item = null) {
        itemToEdit.value = item;
        itemToDelete.value = item;

        switch (modalType) {
            case "create":
                showCreateModal.value = true;
                break;
            case "edit":
                showEditModal.value = true;
                break;
            case "delete":
                showDeleteModal.value = true;
                break;
        }
    }

    /**
     * Closes a modal of the specified type.
     * @param {String} modalType - The type of modal to close ('create', 'edit', 'delete').
     */
    function closeModal(modalType) {
        itemToEdit.value = null;
        itemToDelete.value = null;

        switch (modalType) {
            case "create":
                showCreateModal.value = false;
                break;
            case "edit":
                showEditModal.value = false;
                break;
            case "delete":
                showDeleteModal.value = false;
                break;
        }
        // Reload entity
        try {
            Inertia.reload({ only: [entityName] });
        } catch (error) {
            console.error(`Error reloading ${entityName}:`, error);
        }
    }

    /**
     * Watches the search query and filters items based on the query.
     * Filters items by name or type name.
     */
    watch(searchQuery, (newQuery) => {
        if (newQuery) {
            items.value = page?.props?.[entityName].filter(item =>
                item.name.toLowerCase().includes(newQuery.toLowerCase()) ||
                item.type?.name.toLowerCase().includes(newQuery.toLowerCase())
            ) || [];
        } else {
            items.value = page?.props?.[entityName] || [];
        }
    });

    /**
     * Computed property to get filtered items based on the search query.
     * @returns {Array} - The filtered items.
     */
    const filteredItems = computed(() => {
        return items.value.filter(item =>
            // Filter items by name or type name
            item.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            item.type?.name.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    });

    /**
     * Sorts the table by the specified column.
     * Toggles the sort direction between 'asc', 'desc', and 'none'.
     * @param {String} column - The column to sort by.
     */
    function sortColumn(column) {
        const { direction } = sortConfig.value;
        const newDirection = direction === "asc" ? "desc" : direction === "desc" ? "none" : "asc";

        // Update the sort configuration
        sortConfig.value = { column, direction: newDirection };
    }

    /**
     * Computed property to get sorted items based on the sort configuration.
     * Sorts items by the specified column and direction.
     * @returns {Array} - The sorted items.
     */
    const sortedItems = computed(() => {
        const { column, direction } = sortConfig.value;
        let itemsToSort = [...filteredItems.value];

        // Sort items by the specified column and direction
        if (column && direction !== "none") {
            itemsToSort.sort((a, b) => {
                let aValue = a[column];
                let bValue = b[column];

                // Handle sorting for nested properties
                if (column === 'profiles') {
                    aValue = a.profiles.map(p => p.name).join(", ");
                    bValue = b.profiles.map(p => p.name).join(", ");
                } else if (column === 'type') {
                    aValue = a.type?.name;
                    bValue = b.type?.name;
                }

                // Compare values based on type
                if (typeof aValue === 'number' && typeof bValue === 'number') {
                    return direction === "asc" ? aValue - bValue : bValue - aValue;
                } else {
                    return direction === "asc" ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
                }
            });
        }

        return itemsToSort;
    });

    // Return reactive references and functions
    return {
        showCreateModal,
        showEditModal,
        showDeleteModal,
        itemToEdit,
        itemToDelete,
        searchQuery,
        items,
        types,
        sortConfig,
        openModal,
        closeModal,
        filteredItems,
        sortedItems,
        sortColumn,
    };
}
