<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import axios from "axios";
import SecondaryButton from "@/Components/General/SecondaryButton.vue";
import TertiaryButton from "@/Components/General/TertiaryButton.vue";
import { useNotifications } from "@/plugins/notificationPlugin";

const { success, error } = useNotifications();

const props = defineProps({
  isOpen: Boolean,
  types: {
    type: Array,
    required: true,
  },
});
const emit = defineEmits(["close", "productCreated"]);

const form = useForm({
  product_id: "",
  name: "",
  type_id: "",
  attributes: {},
  weight: "",
  description: "",
  price: "",
  stock_quantity: "",
});

const attributeValues = ref([]); // Store values for dynamically fetched attributes

watch(
    () => form.type_id,
    async (typeId) => {
      if (typeId) {
        try {
          const { data } = await axios.get(`/types/${typeId}/attributes`);
          form.attributes = data;
          attributeValues.value = data.reduce((acc, attr) => {
            acc[attr.id] = ""; // Default value for attributes
            return acc;
          }, {});
        } catch (err) {
          console.error("Failed to fetch attributes:", err);
          form.attributes = [];
          attributeValues.value = {};
        }
      } else {
        form.attributes = [];
        attributeValues.value = {};
      }
    }
);

watch(
    () => props.isOpen,
    (isOpen) => {
      if (isOpen) {
        form.reset();
        form.clearErrors();
        attributeValues.value = {}; // Clear attribute values
      }
    }
);

function closeModal() {
  emit("close");
  form.reset();
  attributeValues.value = {};
}

function submit() {
  const payload = {
    ...form,
    attributeValues: attributeValues.value,
  };

  form.post(route("products.store"), {
    data: payload,
    onSuccess: ({ props }) => {
      success("Product created successfully!");
      emit("productCreated", props.flash.newProduct);
      closeModal();
    },
    onError: () => {
      error("Failed to create product. Please try again.");
    },
  });
}
</script>

<template>
  <div v-if="isOpen" class="create-product-modal">
    <div class="create-product-modal__overlay"></div>
    <div class="create-product-modal__content">
      <h2 class="create-product-modal__title">Create Product</h2>
      <form @submit.prevent="submit" class="create-product-modal__form">
        <label>
          Product ID:
          <input
              class="create-product-modal__input"
              v-model="form.product_id"
              type="text"
              placeholder="Enter product ID"
              required
          />
        </label>
        <label>
          Name:
          <input
              class="create-product-modal__input"
              v-model="form.name"
              type="text"
              placeholder="Enter product name"
              required
          />
        </label>
        <label>
          Type:
          <select
              class="create-product-modal__select"
              v-model="form.type_id"
              required
          >
            <option value="" disabled>Select a type</option>
            <option v-for="type in types" :key="type.id" :value="type.id">
              {{ type.name }}
            </option>
          </select>
        </label>
        <div v-if="form.attributes.length">
          <h3 class="create-product-modal__attributes-title">Attributes</h3>
          <div
              v-for="attr in form.attributes"
              :key="attr.id"
              class="create-product-modal__attribute-field"
          >
            <label :for="`attribute-${attr.id}`">{{ attr.name }}</label>
            <input
                class="create-product-modal__input"
                :id="`attribute-${attr.id}`"
                v-model="attributeValues[attr.id]"
                type="text"
                :placeholder="`Enter ${attr.name}`"
            />
          </div>
        </div>
        <label>
          Weight:
          <input
              class="create-product-modal__input"
              v-model="form.weight"
              type="number"
              placeholder="Enter product weight"
          />
        </label>
        <label>
          Description:
          <textarea
              class="create-product-modal__textarea"
              v-model="form.description"
              placeholder="Enter product description"
          ></textarea>
        </label>
        <label>
          Price:
          <input
              class="create-product-modal__input"
              v-model="form.price"
              type="number"
              placeholder="Enter product price"
              required
          />
        </label>
        <label>
          Stock Quantity:
          <input
              class="create-product-modal__input"
              v-model="form.stock_quantity"
              type="number"
              placeholder="Enter stock quantity"
              required
          />
        </label>
        <div class="create-product-modal__actions">
          <TertiaryButton label="Cancel" type="cancel" @click="closeModal" />
          <SecondaryButton
              label="Create"
              type="submit"
              :disabled="form.processing"
          />
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
.create-product-modal__overlay {
  position: fixed;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 50;
}

.create-product-modal__content {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: #fff;
  padding: 2rem;
  width: 90%;
  max-width: 500px;
  border-radius: 0.5rem;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  z-index: 100;
  overflow-y: auto;
}

.create-product-modal__title {
  font-size: 1.8rem;
  font-weight: bold;
  margin-bottom: 1.5rem;
  color: #333;
}

.create-product-modal__form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.create-product-modal__input {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid rgba(0, 0, 0, 0.2);
  border-radius: 0.375rem;
  font-size: 1rem;
}

.create-product-modal__select {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid rgba(0, 0, 0, 0.2);
  border-radius: 0.375rem;
  font-size: 1rem;
  background-color: #fff;
}

.create-product-modal__textarea {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid rgba(0, 0, 0, 0.2);
  border-radius: 0.375rem;
  font-size: 1rem;
  resize: vertical;
}

.create-product-modal__attributes-title {
  font-size: 1.2rem;
  font-weight: bold;
  margin-bottom: 0.5rem;
}

.create-product-modal__attribute-field {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.create-product-modal__actions {
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
}
</style>
