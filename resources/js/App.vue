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


	},
}


</script>

<template>
    <VueSelection @share="onShare" style="margin-top: 20%;">
       <div id="wholeText"><p>Vue 3 , Laravel 10 with </p>Vite </div>
</VueSelection>
</template>
