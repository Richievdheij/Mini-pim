<script setup>
import { ref, computed } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import { useNotifications } from "@/plugins/notificationPlugin";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Searchbar from "@/Components/General/Searchbar.vue";

const props = defineProps({
    profiles: {
        type: Array,
        required: true,
    },
    permissions: {
        type: Object, // Permissions grouped by categories
        required: true,
    },
});

const { success, error } = useNotifications(); // Use notification plugin

// Reactive variables
const searchQuery = ref("");
const expandedCategories = ref([]); // Track which categories are expanded

const filteredPermissions = computed(() => {
    const result = {};
    Object.keys(props.permissions).forEach((category) => {
        const filtered = props.permissions[category].filter((permission) =>
            permission.name.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
        if (filtered.length > 0) {
            result[category] = filtered;
        }
    });
    return result;
});

// Check if a profile has a permission
function hasPermission(profile, permission) {
    return profile.permissions.some((p) => p.id === permission.id);
}

// Form to update user rights
const form = useForm({
    profile_id: null,
    permission_id: null,
});

// Toggle permission for a profile
function togglePermission(profileId, permissionId) {
    form.profile_id = profileId;
    form.permission_id = permissionId;

    // Find the profile and permission
    const profile = props.profiles.find((p) => p.id === profileId);
    const permission = Object.values(props.permissions)
        .flat()
        .find((p) => p.id === permissionId);

    // Check if permission is already assigned to the profile
    const action = hasPermission(profile, permission) ? "removed from" : "added to";

    form.post(route("user-rights.update"), {
        onSuccess: () => {
            success(`Permission '${permission.name}' has been ${action} profile '${profile.name}'`);
            form.reset("profile_id", "permission_id");
        },
        onError: () => {
            error("Failed to update permission. Please try again.");
        },
    });
}

// Toggle category to expand/collapse
function toggleCategory(category) {
    if (expandedCategories.value.includes(category)) {
        expandedCategories.value = expandedCategories.value.filter((c) => c !== category);
    } else {
        expandedCategories.value.push(category);
    }
}
</script>

<template>
    <Head title="Mini-Pim | User-rights" />

    <AuthenticatedLayout>
        <div class="user-rights">
            <div class="user-rights__header">
                <h1 class="user-rights__title">User Rights</h1>
            </div>

            <div class="user-rights__section">
                <div class="user-rights__top-bar">
                    <div class="user-rights__search-bar">
                        <Searchbar
                            id="search"
                            placeholder="Search..."
                            v-model="searchQuery"
                        />
                    </div>
                </div>

                <!-- Table to display user rights -->
                <table class="user-rights__table">
                    <thead>
                    <tr class="user-rights__table-header">
                        <th class="user-rights__table-header-cell">Category / Rights</th>
                        <th
                            v-for="profile in props.profiles"
                            :key="profile.id"
                            class="user-rights__table-header-cell"
                        >
                            {{ profile.name }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Loop through categories -->
                    <template v-for="(permissions, category) in filteredPermissions" :key="category">
                        <!-- Category Row -->
                        <tr
                            class="user-rights__category-row"
                            @click="toggleCategory(category)"
                        >
                            <td colspan="100%" class="user-rights__category">
                                <strong>
                                    <i
                                        :class="[expandedCategories.includes(category) ? 'fas fa-minus' : 'fas fa-plus']"
                                        class="user-rights__category-icon"
                                    ></i>
                                    {{ category }}
                                </strong>
                            </td>
                        </tr>

                        <!-- Permissions within each category -->
                        <template v-if="expandedCategories.includes(category)">
                            <tr
                                v-for="permission in permissions"
                                :key="permission.id"
                                class="user-rights__table-row"
                            >
                                <td class="user-rights__table-cell">{{ permission.title || permission.name }}</td>
                                <td
                                    v-for="profile in props.profiles"
                                    :key="profile.id"
                                    class="user-rights__table-cell"
                                >
                                    <label class="user-rights__slider">
                                        <input
                                            type="checkbox"
                                            class="user-rights__slider__checkbox"
                                            :checked="hasPermission(profile, permission)"
                                            @change="togglePermission(profile.id, permission.id)"
                                        />
                                        <span class="user-rights__slider__button"></span>
                                    </label>
                                </td>
                            </tr>
                        </template>
                    </template>
                    </tbody>
                </table>

                <!-- Show message if no permissions match the search -->
                <div v-if="Object.keys(filteredPermissions).length === 0" class="user-rights__no-results">
                    <p>No results found</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
