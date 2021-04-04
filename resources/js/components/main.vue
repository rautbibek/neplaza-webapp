<template>
  <v-app style="margin:0px; padding:0px background:red">
    <v-main>
      <topbar></topbar>
      <nav-bar ></nav-bar> 
      <div style="min-height:550px" >
        <router-view></router-view>
        
      </div>
      <div class="space"></div>
      <login></login>
      <sign-up></sign-up>
      <scroll></scroll>
      <email-verify-notif v-if="loggedIn"></email-verify-notif>
      <update-profile></update-profile>
      <footer-bar></footer-bar>
    </v-main>
  </v-app>
</template>
<script>
import topbar from './home/partials/topbar';
import Navbar from './home/partials/navbar';
import login from './login';
import signUp from './signUp';
import emailVerifyNotif from './home/partials/emailVerifyNotification';
import profileForm from './home/back/profileForm';
export default {
  components:{
            topbar,
            login,
            'update-profile':profileForm,
            'sign-up':signUp,
            'nav-bar':Navbar,
            
            'email-verify-notif':emailVerifyNotif,
         },
  data() {

    return {
      
    };
  }
};
</script>
<style scoped>
  .theme--light.v-application{
    background:#f0f2f5;
  } 
  .space{
    height:20px;
  }
</style>
