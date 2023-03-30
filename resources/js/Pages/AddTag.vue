<script setup>
import axios from 'axios';

</script>

<template>
    <div>
        <h3 class="text-center">Add Tag</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addTag">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="tag.name">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Tag</button>
                </form>
            </div>
        </div>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                tag: {}
            }
        },
        methods: {
            addTag() {
                axios
                    .post('http://localhost:8000/tag/add', this.tag)
                    .then(response => (
                        window.location = "/alltags"
                    ))
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
            }
        }
    }
</script>