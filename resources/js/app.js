import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

// Import FontAwesome CSS to use the classic i tag approach
import '@fortawesome/fontawesome-free/css/all.css';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Initialize and configure the Inertia.js app
createInertiaApp({
    title: (title) => `${title} - ${appName}`, // Set the title of the page dynamically based on the Inertia page title
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});