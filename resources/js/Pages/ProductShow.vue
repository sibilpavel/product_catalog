<template>
    <AppLayout>
        <Head title="Product Details" />

        <div v-if="product" class="bg-white rounded shadow p-6">
            <h1 class="text-3xl font-bold mb-4">
                {{ product.name }}
            </h1>

            <p class="text-gray-500 mb-4">
                Category: {{ product.category?.name }}
            </p>

            <p class="mb-4">
                {{ product.description }}
            </p>

            <p class="text-2xl font-bold mb-6">
                ${{ product.price }}
            </p>

            <Link
                href="/"
                class="text-blue-600"
            >
                ← Back to Products
            </Link>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
    productId: Number,
})

const product = ref(null)

const fetchProduct = async () => {
    const response = await axios.get(
        `/api/products/${props.productId}`
    )

    product.value = response.data.data
}

onMounted(() => {
    fetchProduct()
})
</script>
