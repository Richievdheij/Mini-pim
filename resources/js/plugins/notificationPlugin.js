import { useToast } from "vue-toastification";

export function useNotifications() {
    const toast = useToast();

    return {
        success: (message) => toast.success(`🎉 ${message}`),
        error: (message) => toast.error(`❌ ${message}`),
        warning: (message) => toast.warning(`⚠️ ${message}`),
        info: (message) => toast.info(`ℹ️ ${message}`),
    };
}
