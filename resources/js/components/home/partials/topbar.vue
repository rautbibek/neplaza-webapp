<template >
    <!-- app bar -->
    <div>
          <v-container>
            <div class="row">
              <div class="col-md-3 cleaner d-none d-md-flex">
                <a href="/" >
                <v-toolbar-title class="text--grey">
                  <img src="https://neplaza.shivakshaenterprises.com/images/image/logo.png" height="50" alt="">
                </v-toolbar-title>
                </a>
              </div>
              <div class="col-md-6 col-sm-6 cleaner">
                <search></search>
              </div>
              <div class="col-md-3 mt-3 col-sm-6 text-center cleaner">
                <span v-if="loggedIn" >
                  
                 <user-menu></user-menu>
                 
                  
                 </span>
                  <span v-else>
                  <v-btn color="#2F3B59" tile outlined  class="mr-2" dark href="/register" target="_blank">
                    <v-icon left>person_add</v-icon>
                    <span>Sign Up</span>
                  </v-btn>
      
                  <v-btn color="#2F3B59" @click="login"  tile dark outlined>
                    <v-icon left>mdi-account-circle</v-icon>
                    <span>Login</span>
                  </v-btn>
                  </span>
              </div>
            </div>
          </v-container>
            <!-- <span class="font-weight-light">Neplaza</span> -->

</div>
</template>

<script>
  export default {
    data () {
      return {
        //
      }
    },
    methods:{
      login(){
        EventBus.$emit('changeDialog', true);
      }
    },
  }
</script>
<style scoped>
  .row{
    margin:0px;
    padding:0px;
  }
  .cleaner{
    margin:0px;
    padding:0px;
  }
</style>