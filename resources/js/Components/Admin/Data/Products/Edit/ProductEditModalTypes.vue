<script setup>
import { useForm } from "@inertiajs/vue3";
import Input from "@/Components/General/Input.vue";

const props = defineProps({
    types: Array,
    modelValue: String,
});

const emit = defineEmits(["update:modelValue"]);

const form = useForm({
    type_id: props.product?.type_id || "",
});

</script>

<template>
    <div class="edit-product-modal-types">
            <form class="edit-product-modal-types__form">
                <!-- Select product Type -->
                <Input
                    label="Type"
                    id="type_id"
                    type="selectType"
                    v-model="form.type_id"
                    :types="types"
                    optionValue="id"
                    optionLabel="name"
                    placeholder="Select Type"
                    :error="form.errors.type_id"
                />
            </form>
        </div>
</template>
