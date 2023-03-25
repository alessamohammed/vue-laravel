<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import VueSelection from './Selection.vue'

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <VueSelection @share="onShare" style="margin-top: 20%;">
                        <div id="wholeText"><p>Vue 3 , Laravel 10 with </p>Vite </div>
                    </VueSelection>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
