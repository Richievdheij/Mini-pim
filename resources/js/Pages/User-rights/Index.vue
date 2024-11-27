<script setup>
import { ref, computed } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import { useNotifications } from "@/plugins/notificationPlugin"; // Import notification plugin
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Input from "@/Components/General/Input.vue";

const props = defineProps({
    profiles: {
        type: Array,
        required: true,
    },
    permissions: {
        type: Array,
        required: true,
    },
});

const { success, error } = useNotifications(); // Use notification plugin

const searchQuery = ref("");

const filteredPermissions = computed(() => {
    return props.permissions.filter((permission) =>
        permission.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

function hasPermission(profile, permission) {
    return profile.permissions.some((p) => p.id === permission.id);
}

const form = useForm({
    profile_id: null,
    permission_id: null,
});

function togglePermission(profileId, permissionId) {
    form.profile_id = profileId;
    form.permission_id = permissionId;

    const profile = props.profiles.find((p) => p.id === profileId);
    const permission = props.permissions.find((p) => p.id === permissionId);

    const action = hasPermission(profile, permission) ? "removed from" : "added to";

    form.post(route("user-rights.update"), {
        onSuccess: () => {
            success(`Permission '${permission.name}' has been ${action} profile '${profile.name}'`);
            form.reset("profile_id", "permission_id");
        },
        onError: () => {
            error("Failed to update permission. Please try again. ❌");
        },
    });
}
</script>

<template>
    <Head title="Mini-Pim | User-rights" />

    <AuthenticatedLayout>
        <div class="user-rights">
            <div class="user-rights__header">
                <h1 class="user-rights__title">User rights</h1>
            </div>

            <div class="user-rights__section">
                <div class="user-rights__top-bar">
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
                    <thead>
                    <tr class="user-rights__table-header">
                        <th class="user-rights__table-header-cell">Rights</th>
                        <th
                            v-for="profile in props.profiles"
                            :key="profile.id"
                            class="user-rights__table-header-cell"
                        >
                            {{ profile.name }}
                        </th>
                    </tr>
                    </thead>
                    <tbody class="user-rights__table-body">
                    <tr
                        v-for="permission in filteredPermissions"
                        :key="permission.id"
                        class="user-rights__table-row"
                    >
                        <td class="user-rights__table-cell">{{ permission.name }}</td>
                        <td
                            v-for="profile in props.profiles"
                            :key="profile.id"
                            class="user-rights__table-cell"
                        >
                            <label class="user-rights__slider">
                                <input
                                    type="checkbox"
                                    :checked="hasPermission(profile, permission)"
                                    @change="togglePermission(profile.id, permission.id)"
                                />
                                <span class="user-rights__slider-button"></span>
                            </label>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
