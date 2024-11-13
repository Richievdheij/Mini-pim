<script setup>
import { useForm } from '@inertiajs/vue3';

defineProps({ profiles: Array, permissions: Array})

// Check if a profile has a specific permission
function hasPermission(profile, permission) {
    return profile.permissions.some((p) => p.id === permission.id);
}

// Toggle permission for a profile
const form = useForm({ profile_id: null, permission_id: null });
function togglePermission(profileId, permissionId) {
    form.profile_id = profileId;
    form.permission_id = permissionId;

    form.post(route('profiles.toggle-permission'), {
        onSuccess: () => {
            form.reset('profile_id', 'permission_id');
        },
    });
}
</script>

<template>
    <div class="manage-permissions">
        <h1>Manage Permissions</h1>
        <table class="permissions-table">
            <thead>
            <tr>
                <th>Right</th>
                <th v-for="profile in profiles" :key="profile.id">
                    {{ profile.name }}
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="permission in permissions" :key="permission.id">
                <td>{{ permission.name }}</td>
                <td
                    v-for="profile in profiles"
                    :key="profile.id"
                    class="permission-toggle"
                >
                    <input
                        type="checkbox"
                        :checked="hasPermission(profile, permission)"
                        @change="togglePermission(profile.id, permission.id)"
                    />
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

