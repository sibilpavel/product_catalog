<template>
    <AppLayout>
        <Head title="Products" />

        <h1 class="text-3xl font-bold mb-6">
            Products
        </h1>

        <!-- FILTER -->
        <div class="mb-6 flex gap-4 items-center">
            <select
                v-model="selectedCategory"
                @change="fetchProducts(1)"
                class="border rounded px-4 py-2"
            >
                <option value="">All Categories</option>

                <option
                    v-for="category in categories"
                    :key="category.id"
                    :value="category.id"
                >
                    {{ category.name }}
                </option>
            </select>
        </div>

        <!-- PRODUCTS -->
        <div
            v-if="products.length"
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
        >
            <div
                v-for="product in products"
                :key="product.id"
                class="bg-white rounded shadow p-5"
            >
                <h2 class="text-xl font-semibold mb-2">
                    {{ product.name }}
                </h2>

                <p class="text-sm text-gray-500 mb-2">
                    {{ product.category?.name }}
                </p>

                <p class="mb-3">
                    {{ product.description }}
                </p>

                <p class="font-bold mb-4">
                    ${{ product.price }}
                </p>

                <Link
                    :href="`/product/${product.id}`"
                    class="text-blue-600"
                >
                    View Details
                </Link>
            </div>
        </div>

        <!-- EMPTY -->
        <div v-else>
            No products found
        </div>

        <!-- PAGINATION -->
        <div
            v-if="lastPage > 1"
            class="flex items-center justify-center gap-4 mt-10"
        >
            <button
                class="px-4 py-2 border rounded disabled:opacity-50"
                :disabled="currentPage === 1"
                @click="fetchProducts(currentPage - 1)"
            >
                Prev
            </button>

            <span>
                Page {{ currentPage }} / {{ lastPage }}
            </span>

            <button
                class="px-4 py-2 border rounded disabled:opacity-50"
                :disabled="currentPage === lastPage"
                @click="fetchProducts(currentPage + 1)"
            >
                Next
            </button>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const products = ref([])
const categories = ref([])

const selectedCategory = ref('')

const currentPage = ref(1)
const lastPage = ref(1)

const fetchCategories = async () => {
    const response = await axios.get('/api/categories')
    categories.value = response.data.data
}

const fetchProducts = async (page = 1) => {
    const params = new URLSearchParams()

    params.append('page', page)

    if (selectedCategory.value) {
        params.append('category_id', selectedCategory.value)
    }

    const response = await axios.get(`/api/products?${params.toString()}`)

    products.value = response.data.data

    currentPage.value = response.data.meta.current_page
    lastPage.value = response.data.meta.last_page
}

onMounted(() => {
    fetchCategories()
    fetchProducts()
})
</script>
