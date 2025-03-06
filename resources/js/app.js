import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { InertiaProgress } from '@inertiajs/progress';

// Sidebar configuration
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';
import '../sass/components/pim-notification.scss'; // Custom Toast styles

// FontAwesome CSS
import '@fortawesome/fontawesome-free/css/all.css';

// Toast options
const toastOptions = {
    timeout: 3000, // Default timeout for all toasts
    position: "top-right", // Default position
    draggable: false, // Keep it simple
    pauseOnHover: true, // Pause timer when hovering
    closeOnClick: true, // Close toast on click
};

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Initialize Inertia.js app
createInertiaApp({
    title: (title) => `${title} - ${appName}`, // Dynamically set the page title
    resolve: (name) =>
        resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')), // Correct backtick closure
    setup({ el, App, props, plugin }) {
        // Create Vue app instance
        const app = createApp({ render: () => h(App, { ...props, sidebarConfig }) });

        // Register plugins
        app.use(plugin) // Inertia.js plugin
            .use(ZiggyVue) // Ziggy for routing
            .use(Toast, toastOptions); // Toastification

        // Mount the app
        app.mount(el);
    },
});

// Initialize Inertia Progress
InertiaProgress.init({
    color: '#4B5563',
});
