<template>
  <v-app id="inspire">
    
    <admin-sidebar></admin-sidebar>
    
    
      <router-view></router-view>

      <dialog-component></dialog-component>
  </v-app>
</template>

<script>
  export default {
    props: {
      source: String,
    },
    data(){
      return{
        dialog: false,
      }
    }
   
    
  }
</script>