<script setup>
import { Head,Link } from '@inertiajs/vue3';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

</script>

<template>
     <Head title="Tags" />
     <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">All Tags</h2>
        </template>
        <Link
                v-if="$page.props.auth.user"
                :href="route('addtag')"
                class=" font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >addTag</Link>
    <div class="container d-flex align-items-center justify-content-center">
        
        <table class="table table-bordered ">
            
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="tag in tags" :key="tag.id">
                <td>{{ tag.id }}</td>
                <td>{{ tag.name }}</td>
                <td>{{ tag.created_at }}</td>
                <td>{{ tag.updated_at }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-danger" @click="deletetag(tag.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    </AuthenticatedLayout>
</template>
 
<script>
    export default {
        data() {
            return {
                tags: []
            }
        },
        created() {
            axios
                .get('http://localhost:8000/tags')
                .then(response => {
                    this.tags = response.data;
                });
        },
        methods: {
            deletetag(id) {
                axios
                    .delete(`http://localhost:8000/tag/delete/${id}`)
                    .then(response => {
                        let i = this.tags.map(item => item.id).indexOf(id); // find index of your object
                        this.tags.splice(i, 1)
                    });
            }
        }
    }
</script>