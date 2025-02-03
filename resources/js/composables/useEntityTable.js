import { ref, computed, watch } from 'vue';
import { usePage, router } from '@inertiajs/vue3';

/**
 * A composable function to manage entity tables with modals for creating, editing, and deleting items.
 *
 * @param {string} entityName - The name of the entity to manage.
 * @returns {Object} - The reactive properties and methods for managing the entity table.
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
     * Open a modal of the specified type.
     *
     * @param {string} modalType - The type of modal to open ('create', 'edit', 'delete').
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
     * Close a modal of the specified type and reload the entity data.
     *
     * @param {string} modalType - The type of modal to close ('create', 'edit', 'delete').
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
        try {
            router.reload({ only: [entityName] });
        } catch (error) {
            console.error(`Error reloading ${entityName}:`, error);
        }
    }

    // Watch for changes in the search query and filter items accordingly
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

    // Computed property for filtered items based on the search query
    const filteredItems = computed(() => {
        return items.value.filter(item =>
            item.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            item.type?.name.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    });

    /**
     * Sort the items by the specified column.
     *
     * @param {string} column - The column to sort by.
     */
    function sortColumn(column) {
        const { direction } = sortConfig.value;
        const newDirection = direction === "asc" ? "desc" : direction === "desc" ? "none" : "asc";

        sortConfig.value = { column, direction: newDirection };
    }

    // Computed property for sorted items based on the sort configuration
    const sortedItems = computed(() => {
        const { column, direction } = sortConfig.value;
        let itemsToSort = [...filteredItems.value];

        if (column && direction !== "none") {
            itemsToSort.sort((a, b) => {
                const aValue = column === 'type' ? a[column]?.name : a[column];
                const bValue = column === 'type' ? b[column]?.name : b[column];

                return direction === "asc" ? aValue.localeCompare(bValue) : bValue.localeCompare(aValue);
            });
        }

        return itemsToSort;
    });

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
