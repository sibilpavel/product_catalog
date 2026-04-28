<template>
    <div class="min-h-screen bg-gray-100">
        <Navbar />

        <main class="max-w-7xl mx-auto px-6 py-8">
            <slot />
        </main>
    </div>
</template>

<script setup>
import Navbar from '@/Components/Navbar.vue'
</script>
