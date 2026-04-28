<template>
    <AppLayout>
        <Head title="Create Product" />

        <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
            <h1 class="text-2xl font-bold mb-6">
                Create Product
            </h1>

            <form @submit.prevent="submit">
                <input
                    v-model="form.name"
                    placeholder="Product Name"
                    class="w-full border rounded px-4 py-2 mb-4"
                    required
                />

                <select
                    v-model="form.category_id"
                    class="w-full border rounded px-4 py-2 mb-4"
                    required
                >
                    <option value="">
                        Select Category
                    </option>

                    <option
                        v-for="category in categories"
                        :key="category.id"
                        :value="category.id"
                    >
                        {{ category.name }}
                    </option>
                </select>

                <textarea
                    v-model="form.description"
                    placeholder="Description"
                    class="w-full border rounded px-4 py-2 mb-4"
                />

                <input
                    v-model="form.price"
                    type="number"
                    min="1"
                    step="0.01"
                    placeholder="Price"
                    class="w-full border rounded px-4 py-2 mb-4"
                    required
                />

                <button
                    class="bg-black text-white px-6 py-2 rounded"
                >
                    Save
                </button>
            </form>
            <p
                v-if="errors"
                class="text-red-600 mb-4"
            >
                {{ errors[Object.keys(errors)[0]]?.[0] }}
            </p>
        </div>
    </AppLayout>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue'
import { router, Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import api from '@/lib/api'
import { useAuth } from '@/Composables/useAuth'
const { isAuthenticated } = useAuth()
const categories = ref([])

const form = reactive({
    name: '',
    description: '',
    price: '',
    category_id: '',
})

const errors = ref({})


const fetchCategories = async () => {
    const response = await api.get('/api/categories')
    categories.value = response.data.data
}

const submit = async () => {
    try{
        await api.post('/api/products', form)
        errors.value = {}
        router.visit('/admin/products')
    }catch (e){
        if (e.response?.status === 422) {
            errors.value = e.response.data.errors
        }else{
            errors.value = {"Error": ["Error"]}
        }
    }

}

onMounted(() => {
    if (!isAuthenticated()) {
        router.visit('/login')
    }
    fetchCategories()
})
</script>
