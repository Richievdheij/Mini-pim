<script setup>
import { ref, computed } from "vue";
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Input from "@/Components/General/Input.vue";

// Define props properly
const props = defineProps({
    profiles: {
        type: Array,
        required: true
    },
    permissions: {
        type: Array,
        required: true
    }
});

// Local state for search query
const searchQuery = ref('');

// Filter permissions based on the search query
const filteredPermissions = computed(() => {
    return props.permissions.filter(permission =>
        permission.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

// Check if a profile has a specific permission
function hasPermission(profile, permission) {
    return profile.permissions.some((p) => p.id === permission.id);
}

// Form setup to handle the toggle of permissions
const form = useForm({
    profile_id: null,
    permission_id: null
});

// Toggle permission for a given profile
function togglePermission(profileId, permissionId) {
    form.profile_id = profileId;
    form.permission_id = permissionId;

    form.post(route('user-rights.update'), {
        onSuccess: () => {
            form.reset('profile_id', 'permission_id');
        },
    });
}
</script>

<template>
    <Head title="Mini-Pim | User-rights"/>

    <AuthenticatedLayout>
        <div class="user-rights">
            <!-- Header -->
            <div class="user-rights__header">
                <h1 class="user-rights__title">Manage Permissions</h1>
            </div>

            <!-- Section -->
            <div class="user-rights__section">
                <div class="user-rights__top-bar">
                    <!-- Search Bar -->
                    <div class="user-rights__search-bar">
                        <Input
                            type="search"
                            id="search"
                            placeholder="Search..."
                            v-model="searchQuery"
                            icon="fas fa-search"
                        />
                    </div>
                </div>

                <table class="user-rights__table">
                    <thead class="user-rights__table-header">
                    <tr class="user-rights__row">
                        <th class="user-rights__column">Rights</th>
                        <th
                            v-for="profile in props.profiles"
                            :key="profile.id"
                            class="user-rights__column"
                        >
                            {{ profile.name }}
                        </th>
                    </tr>
                    </thead>
                    <tbody class="user-rights__table-body">
                    <tr
                        v-for="permission in filteredPermissions"
                        :key="permission.id"
                        class="user-rights__row"
                    >
                        <td class="user-rights__cell">{{ permission.name }}</td>
                        <td
                            v-for="profile in props.profiles"
                            :key="profile.id"
                            class="user-rights__cell user-rights__toggle"
                        >
                            <label class="user-rights__switch">
                                <input
                                    type="checkbox"
                                    class="user-rights__checkbox"
                                    :checked="hasPermission(profile, permission)"
                                    @change="togglePermission(profile.id, permission.id)"
                                />
                                <span class="user-rights__slider"></span>
                            </label>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
