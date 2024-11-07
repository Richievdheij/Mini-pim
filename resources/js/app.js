import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { InertiaProgress } from '@inertiajs/progress';

// Import FontAwesome CSS
import '@fortawesome/fontawesome-free/css/all.css';

// Import Sidebar configuration
import { sidebarConfig } from './Config/Sidebar/sidebarConfig.js';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Initialize and configure the Inertia.js app
createInertiaApp({
    title: (title) => `${title} - ${appName}`, // Set the page title dynamically
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')), // Resolve pages
    setup({ el, App, props, plugin }) {
        // Pass sidebarConfig to the main app or component
        return createApp({ render: () => h(App, { ...props, sidebarConfig }) })
            .use(plugin)
            .use(ZiggyVue) // Initialize Ziggy for routing
            .mount(el);
    },
});

// Initialize Inertia Progress
InertiaProgress.init({
    color: '#4B5563', // Progress bar color
});
