<template>
    <AppLayout>
        <Head title="Login" />

        <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
            <h1 class="text-2xl font-bold mb-6">
                Admin Login
            </h1>

            <form @submit.prevent="submit">
                <div class="mb-4">
                    <input
                        v-model="form.email"
                        type="email"
                        placeholder="Email"
                        class="w-full border rounded px-4 py-2"
                        required
                    />
                </div>

                <div class="mb-4">
                    <input
                        v-model="form.password"
                        type="password"
                        placeholder="Password"
                        class="w-full border rounded px-4 py-2"
                        required
                    />
                </div>

                <button
                    class="w-full bg-black text-white py-2 rounded"
                >
                    Login
                </button>
            </form>
            <p
                v-if="error"
                class="text-red-600 mb-4"
            >
                {{ error }}
            </p>
        </div>
    </AppLayout>
</template>

<script setup>
import {reactive, ref} from 'vue'
import { router, Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { useAuth } from '@/Composables/useAuth'

const { login } = useAuth()

const form = reactive({
    email: '',
    password: '',
})

const error = ref('')

const submit = async () => {
    try {
        error.value = ''

        await login(form.email, form.password)

        router.visit('/admin/products')
    } catch (e) {
        error.value = 'Invalid email or password'
    }
}
</script>
