<template>
  <v-app style="margin:0px; padding:0px background:#00000000">
    <v-main>
      <!-- <system-bar></system-bar> -->
      <top-bar></top-bar>
      <nav-bar ></nav-bar> 
      <div style="min-height:400px">
        <router-view></router-view>
      </div>
      <login></login>
      <sign-up></sign-up>
      <update-profile></update-profile>
      <scroll></scroll>
      <footer-bar></footer-bar>
    </v-main>
  </v-app>
</template>
<script>

export default {
  data() {
    return {
      //
    };
  }
};
</script>
<style scoped>
  .theme--light.v-application{
    background:#00000000;
    color:#002f34;
  }
</style>
