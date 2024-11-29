import GeneralSection from '@/Components/Sidebar/Manager/GeneralSection.vue';
import ManageSection from '@/Components/Sidebar//Manager/ManageSection.vue';
import AccountSection from '@/Components/Sidebar/AccountSection.vue';
import ProfileSection from '@/Components/Sidebar/ProfileSection.vue';
import MainSection from '@/Components/Sidebar/MainSection.vue';

export const sidebarConfig = {
    sections: [
        {
            name: 'main',
            label: 'Main',
            component: MainSection,
            expanded: true,
            buttons: [
                { label: 'Manager', icon: 'fa-tachometer-alt', route: 'manager.dashboard' },
                { label: 'PIM', icon: 'fa-cogs', route: 'pim.dashboard' }
            ]
        },
        {
            name: 'general',
            label: 'General',
            component: GeneralSection,
            expanded: true,
            buttons: [
                { label: 'Users', icon: 'fa-users', route: 'users' },
                { label: 'Profiles', icon: 'fa-user-circle', route: 'profiles' },
                { label: 'User rights', icon: 'fa-user-shield', route: 'user-rights' }
            ]
        },
        {
            name: 'manage',
            label: 'Manage',
            component: ManageSection,
            expanded: false,
            buttons: [
                { label: 'Logs', icon: 'fa-file-alt', route: 'logs' },
                { label: 'Settings', icon: 'fa-cogs', route: 'settings' }
            ]
        },
        {
            name: 'account',
            label: 'Account',
            component: AccountSection,
            expanded: false,
            buttons: [
                { label: 'Account settings', icon: 'fa-user', route: 'profile.edit' },
                { label: 'Logout', icon: 'fa-sign-out-alt', action: 'logout' }
            ]
        },
        {
            name: 'profile',
            label: 'Profile',
            component: ProfileSection,
            expanded: false,
            buttons: []
        }
    ],
    activeView: 'manager', // Default view
};
