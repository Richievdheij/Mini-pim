<script>
import Categories from '@/Components/Dashboard/SideBar/CategoriesContainer.vue';
import TopPosts from '@/Components/Posts/TopPosts/TopPostsContainer.vue';
import axios from 'axios'; // To fetch data from the backend
import { ref } from 'vue'; // Import ref for reactivity

export default {
    props: {
        selectedCategory: String, // Currently selected category
        topPosts: Array, // Array of top posts
    },
    components: {
        Categories,
        TopPosts,
    },
    setup() {
        const categories = ref([]); // Reactive array to store fetched categories
        const selectedCategory = ref('All blogs'); // Default category for selected

        // Fetch categories when the component is mounted
        const fetchCategories = async () => {
            try {
                const response = await axios.get('/categories'); // Fetch categories from backend
                categories.value = response.data; // Store fetched categories in the reactive array
            } catch (error) {
                console.error('Error fetching categories:', error);
            }
        };

        // Handle the selected category change
        const handleCategorySelected = (category) => {
            selectedCategory.value = category; // Update the selected category
        };

        // Fetch categories on component mount
        fetchCategories();

        return {
            categories,
            selectedCategory,
            handleCategorySelected,
        };
    },
};
</script>

<template>
    <aside class="sidebar">
        <!-- Categorieën sectie -->
        <Categories
            :categories="categories"
            :selectedCategory="selectedCategory"
            @categorySelected="handleCategorySelected"
        />

        <!-- Top posts sectie -->
        <TopPosts :topPosts="topPosts" /> <!-- topPosts prop used here -->
    </aside>
</template>
