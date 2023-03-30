<script setup>
import { Head,Link } from '@inertiajs/vue3';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

</script>

<template>
    
     <Head title="Resources" />
     <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">All Resources</h2>
        </template>
        
    <div class="container ">
        <div class="col-4 mb-3">
        <div class="form-group row">
            <label for="tags">Tags</label>
            <select class="form-control" id="tags" multiple v-model="filterTags" v-on:change="filterResources()">
                <option v-for="tag in tags" v-bind:value="{ id: tag.id, name: tag.name }">{{ tag.name }}</option>
            </select>
        </div>
    </div>
    <div class="row">
        <table class="table table-bordered ">
           
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Tags</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="resource in resources" :key="resource.id">
                <td>{{ resource.id }}</td>
                <td>{{ resource.name }}</td>
                <td>
                    <div v-for="tag in resource.tags" :key="tag.id">
                        <span class="badge bg-primary">{{ tag.name }}</span>
                    </div>
                    </td>
                <td><select class="form-control" v-model="Selected[resource.id]">
                        <option v-for="tag in tags" v-bind:value="{ id: tag.id, name: tag.name }">{{ tag.name }}</option>
                    </select></td>
                    <td>
                       
                    <div class="btn-group" role="group">
                        <button class="btn btn-primary" v-on:click="maptag($page.props.auth.user.id,Selected[resource.id].id, resource.id)">Map Tag</button>
                        <button class="btn btn-danger" v-on:click="unmaptag($page.props.auth.user.id,Selected[resource.id].id, resource.id)">Unmap Tag</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        </div>
    </div>
    </AuthenticatedLayout>
    
</template>
 
<script>
    export default {
        data() {
            return {
                resources: [],
                tags: [],
                Selected: [],
                filteredResources: [],
                filterTags: []
            }
        },
        created() {
            axios
                .get('http://localhost:8000/tags')
                .then(response => {
                    this.tags = response.data;
                });
            axios
                .get('http://localhost:8000/resources')
                .then(response => {
                    this.resources = response.data;
            })

        },
        methods: {
            filterResources() {
                let selectedTags = this.filterTags;
                this.resources.forEach(resource => {
                    let tags = resource.tags;
                    let found = false;
                    tags.forEach(tag => {
                        selectedTags.forEach(selectedTag => {
                            if (tag.name === selectedTag.name) {
                                found = true;
                            }
                            else {
                                found = false;
                            }
                        });
                    });
                    if (found) {
                        this.filteredResources.push(resource);
                    }
                });
                this.resources = this.filteredResources;
            },
        
            maptag(user_id ,tag_id, resource_id) {
                if (user_id && tag_id && resource_id)
                axios
                    .post(`http://localhost:8000/resource/maptag`, {
                        user_id: user_id,
                        tag_id: tag_id,
                        resource_id: resource_id
                    })
            },
            unmaptag(user_id ,tag_id, resource_id) {
                if (user_id && tag_id && resource_id)
                axios
                    .post(`http://localhost:8000/resource/unmaptag`, {
                        user_id: user_id,
                        tag_id: tag_id,
                        resource_id: resource_id
                    })
            }
        }
    }
</script>