<script setup>
import { useForm } from "@inertiajs/vue3";
import { watch } from "vue";
import { useNotifications } from "@/plugins/notificationPlugin";
import Input from "@/Components/General/Input.vue";

const props = defineProps({
    types: Array,
    isOpen: Boolean,
});

const emit = defineEmits(["productUpdated"]);

const { success, error } = useNotifications();

const form = useForm({
    type_id: props.product?.type_id || "",
});

watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen && props.product) {
            form.fill(props.product);
        }
    }
);
function submit() {
    form.put(route("pim.products.update", props.product.id), {
        onSuccess: ({props}) => {
            success("Product updated successfully!");
            emit("productUpdated", props.flash.updatedProduct);
            closeModal();
        },
        onError: () => {
            error("Failed to update product. Please try again.");
        },
    });
}
</script>

<template>
    <div v-if="isOpen" class="edit-product-modal">
        <div class="edit-product-modal__overlay"></div>
        <div class="edit-product-modal__content">
            <h2 class="edit-product-modal__title"></h2>
            <h3 class="edit-product-modal__subtitle">Types</h3>

            <form @submit.prevent="submit" class="edit-product-modal__form">
                <!-- Type select input field -->
                <Input
                    label="Type"
                    id="type"
                    type="selectType"
                    placeholder="Select Type"
                    v-model="form.type_id"
                    :types="types"
                    :error="form.errors.type_id"
                />
            </form>
        </div>
    </div>
</template>
