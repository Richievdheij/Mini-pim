<script setup>
import { useForm } from "@inertiajs/vue3";
import { watch } from "vue";
import { useNotifications } from "@/plugins/notificationPlugin";

const props = defineProps({
  isOpen: Boolean,
});
const emit = defineEmits(["close", "productCreated"]);

const { success, error } = useNotifications();

const form = useForm({
  product_id: "",
  name: "",
  type_id: "",
  weight: "",
  description: "",
  price: "",
  stock_quantity: "",
});

watch(
    () => props.isOpen,
    (isOpen) => {
      if (isOpen) {
        form.reset();
        form.clearErrors();
      }
    }
);

function closeModal() {
  emit("close");
  form.reset();
  form.clearErrors();
}

function submit() {
  form.post(route("products.store"), {
    onSuccess: ({ props }) => {
      success("Product created successfully!");
      emit("productCreated", props.flash.newProduct); // Emit the new product
      closeModal();
    },
    onError: () => {
      error("Failed to create product. Please try again.");
    },
  });
}
</script>

<template>
  <div class="modal">
    <div class="modal-content">
      <h2>Create Product</h2>
      <form @submit.prevent="submit">
        <label>
          Product ID:
          <input v-model="form.product_id" type="text" required />
        </label>
        <label>
          Name:
          <input v-model="form.name" type="text" required />
        </label>
        <label>
          Type:
          <select v-model="form.type_id" required>
            <!-- Dynamisch met types -->
          </select>
        </label>
        <label>
          Weight:
          <input v-model="form.weight" type="number" />
        </label>
        <label>
          Description:
          <textarea v-model="form.description"></textarea>
        </label>
        <label>
          Price:
          <input v-model="form.price" type="number" required />
        </label>
        <label>
          Stock Quantity:
          <input v-model="form.stock_quantity" type="number" required />
        </label>
        <div class="modal-actions">
          <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-secondary" @click="closeModal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
/* Voeg modal-styling toe */
</style>
