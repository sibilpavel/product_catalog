<template>
    <nav class="bg-white border-b shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <Link
                href="/"
                class="text-xl font-bold"
            >
                Product Catalog
            </Link>

            <div class="flex items-center gap-4">
                <Link href="/">
                    Products
                </Link>

                <template v-if="isAuthenticated()">
                    <Link href="/admin/products">
                        Admin
                    </Link>

                    <button
                        @click="handleLogout"
                        class="text-red-600"
                    >
                        Logout
                    </button>
                </template>

                <template v-else>
                    <Link href="/login">
                        Login
                    </Link>
                </template>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { router, Link } from '@inertiajs/vue3'
import { useAuth } from '@/Composables/useAuth'

const { logout, isAuthenticated } = useAuth()

const handleLogout = async () => {
    await logout()

    router.visit('/')
}
</script>
