<script setup>
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({
    profiles: Array,
    permissions: Array
});

// Check if a profile has a specific permission
function hasPermission(profile, permission) {
    return profile.permissions.some((p) => p.id === permission.id);
}

// Toggle permission for a profile
const form = useForm({
    profile_id: null,
    permission_id: null
});

function togglePermission(profileId, permissionId) {
    form.profile_id = profileId;
    form.permission_id = permissionId;

    form.post(route('user-rights.index'), {
        onSuccess: () => {
            form.reset('profile_id', 'permission_id');
        },
    });
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="user-rights">
            <!-- Header -->
            <div class="user-rights__header">
                <h1 class="user-rights__title">Manage Permissions</h1>
            </div>

            <!-- Section -->
            <div class="user-rights__section">
                <table class="user-rights__table">
                    <thead class="user-rights__table-header">
                    <tr class="user-rights__row">
                        <th class="user-rights__column">Right</th>
                        <th
                            v-for="profile in profiles"
                            :key="profile.id"
                            class="user-rights__column"
                        >
                            {{ profile.name }}
                        </th>
                    </tr>
                    </thead>
                    <tbody class="user-rights__table-body">
                    <tr
                        v-for="permission in permissions"
                        :key="permission.id"
                        class="user-rights__row"
                    >
                        <td class="user-rights__cell">{{ permission.name }}</td>
                        <td
                            v-for="profile in profiles"
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
