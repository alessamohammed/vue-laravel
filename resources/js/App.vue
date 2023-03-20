<script>
import VueSelection from './selection.vue'
export default {
  components: {
    VueSelection
  },
  methods: {
   
        onShare (text) {
        console.log('share:', text)
    },

    onHighlight (text) {
        console.log('highlight:', text)
    }

	},
}


</script>

<template>
    <VueSelection @share="onShare" @highlight="onHighlight">
        Vue 3 , Laravel 10 with Vite
</VueSelection>
</template>
