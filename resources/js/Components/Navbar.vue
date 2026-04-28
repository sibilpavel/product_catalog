<template>
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between">
            <div>
                <Link href="/" class="font-bold text-xl">
                    Product Catalog
                </Link>
            </div>

            <div class="flex gap-4">
                <Link href="/">
                    Products
                </Link>

                <Link href="/login">
                    Login
                </Link>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>
