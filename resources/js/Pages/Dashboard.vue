<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import VueSelection from './Selection.vue'

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>
        <Link
                v-if="$page.props.auth.user"
                :href="route('alltags')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Tags</Link
            >
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <VueSelection @share="onShare">
                        <div id="wholeText">
                            <p><a href="#">قانونية </a>هي منصة تقدم خدمات <a href="#"> مساندة للقانونيين </a>
                              وذلك بتوفير قاعدة بيانات نوعية تشمية اكثر من ثلاثين ألف &nbsp; مستند خاصاّ 
                               ووثيقة <a>قانونية </a>تتضمن قاعدة البيانات أحكام وقرارات وانظمة ولوائح متعلقة بالنظام السعودي &nbsp;<br>
                            </p>
                        </div>
                    </VueSelection>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


