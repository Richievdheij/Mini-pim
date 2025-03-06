import { useToast } from "vue-toastification";

// Create a custom hook to use the toast functions
export function useNotifications() {
    const toast = useToast();

    // Return the functions that you want to use in your component
    return {
        success: (message) => toast.success(` ${message}`),
        error: (message) => toast.error(` ${message}`),
        warning: (message) => toast.warning(`⚠ ${message}`),
        info: (message) => toast.info(` ${message}`),
    };
}
