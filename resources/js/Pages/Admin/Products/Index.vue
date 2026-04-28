<template>
    <AppLayout>
        <Head title="Admin Products" />

        <div class="flex justify-between mb-6">
            <h1 class="text-3xl font-bold">
                Manage Products
            </h1>

            <Link
                href="/admin/products/create"
                class="bg-black text-white px-4 py-2 rounded"
            >
                Add Product
            </Link>
        </div>

        <div
            v-for="product in products"
            :key="product.id"
            class="bg-white p-4 rounded shadow mb-4"
        >
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="font-bold">
                        {{ product.name }}
                    </h2>

                    <p class="text-gray-500">
                        {{ product.category?.name }}
                    </p>

                    <p>
                        ${{ product.price }}
                    </p>
                </div>

                <div class="flex gap-3">
                    <Link
                        :href="`/admin/products/${product.id}/edit`"
                        class="text-blue-600"
                    >
                        Edit
                    </Link>

                    <button
                        @click="remove(product.id)"
                        class="text-red-600"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>

        <!-- PAGINATION -->
        <div
            v-if="lastPage > 1"
            class="flex items-center justify-center gap-4 mt-8"
        >
            <button
                @click="fetchProducts(currentPage - 1)"
                :disabled="currentPage === 1"
                class="border px-4 py-2 rounded"
            >
                Prev
            </button>

            <span>
                Page {{ currentPage }} / {{ lastPage }}
            </span>

            <button
                @click="fetchProducts(currentPage + 1)"
                :disabled="currentPage === lastPage"
                class="border px-4 py-2 rounded"
            >
                Next
            </button>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '@/lib/api'
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

import { router } from '@inertiajs/vue3'
import { useAuth } from '@/Composables/useAuth'
import {ProductApi} from "../../../api/products.js";

const { isAuthenticated } = useAuth()


const products = ref([])

const currentPage = ref(1)
const lastPage = ref(1)

const fetchProducts = async (page = 1) => {
    const response = await ProductApi.getAll(page)

    products.value = response.data.data
    currentPage.value = response.data.meta.current_page
    lastPage.value = response.data.meta.last_page
}

const remove = async (id) => {
    if (!confirm('Delete product?')) return

    await ProductApi.delete(id)

    fetchProducts(currentPage.value)
}

onMounted(() => {
    if (!isAuthenticated()) {
        router.visit('/login')
    }
    fetchProducts()
})
</script>
