<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import Button from '@/Components/General/Button.vue';
import EditUserModal from '@/Components/Admin/EditUserModal.vue';

defineProps({
    users: Array,
    currentUserRole: String,
    roles: Array, // Add roles prop if roles are being passed down
});

const isModalOpen = ref(false);
const selectedUser = ref(null);

function openEditModal(user) {
    selectedUser.value = user;
    isModalOpen.value = true;
}

function closeEditModal() {
    isModalOpen.value = false;
    selectedUser.value = null;
}

function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user?')) {
        router.delete(route('users.destroy', id));
    }
}
</script>

<template>
    <div class="user-list">
        <h1 class="user-list__title">User List</h1>
        <table class="user-list__table">
            <thead>
            <tr class="user-list__table-header">
                <th class="user-list__table-header-cell">Name</th>
                <th class="user-list__table-header-cell">Email</th>
                <th class="user-list__table-header-cell">Roles</th>
                <th v-if="currentUserRole === 'admin'" class="user-list__table-header-cell">Actions</th>
            </tr>
            </thead>
            <tbody class="user-list__table-body">
            <tr v-for="user in users" :key="user.id" class="user-list__table-body-row">
                <td class="user-list__table-body-cell user-list__table-cell--name">{{ user.name }}</td>
                <td class="user-list__table-body-cell user-list__table-cell--email">{{ user.email }}</td>
                <td class="user-list__table-body-cell user-list__table-cell--roles">
                    <ul>
                        <li v-for="role in user.roles" :key="role.id">{{ role.name }}</li>
                    </ul>
                </td>
                <td v-if="currentUserRole === 'admin'"
                    class="user-list__table-body-cell user-list__table-cell--actions">
                    <Button label="Edit" @click="openEditModal(user)" type="submit"
                            class="bg-A6ABD0-500 text-white px-4 py-2 rounded mr-2"/>
                    <form :action="route('users.destroy', user.id)" method="POST" @submit.prevent="deleteUser(user.id)"
                          class="inline">
                        <input type="hidden" name="_method" value="DELETE">
                        <Button label="Delete" type="delete" class="bg-2859A6-500 text-white px-4 py-2 rounded"/>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
        <div v-if="currentUserRole === 'admin'" class="user-list__create-button">
            <Link :href="route('users.create')">
                <Button label="Create New User" type="submit" class="bg-blue-500 text-white px-4 py-2 rounded"/>
            </Link>
        </div>

        <!-- Edit Modal -->
        <EditUserModal :user="selectedUser"
                       :roles="roles"
                       :isOpen="isModalOpen"
                       @close="closeEditModal"/>
    </div>
</template>
