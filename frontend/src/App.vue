<script setup>
import { RouterView } from 'vue-router'
</script>

<template>
    <div>
        <header class="bg-blue-600 text-white py-4 shadow-md">
            <div class="container mx-auto flex justify-between items-center px-6">
                <h1 class="text-3xl font-bold tracking-wide">CinemaScope</h1>
            </div>
            <nav class="right-0">
                <router-link to="/" class="nav-link p-2">Home</router-link>
                <router-link to="/trend" class="nav-link p-2">Trends</router-link>
            </nav>
        </header>

        <main class="container mx-auto p-6">
            <div class="wrapper bg-white shadow-lg rounded-lg p-6">
                <RouterView />
            </div>
        </main>
    </div>
</template>

<style scoped>

</style>
