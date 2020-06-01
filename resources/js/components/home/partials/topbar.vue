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
                 <v-menu offset-y nudge-bottom="15" open-on-click close-on-content-click transition="scale-transition">
                   <template v-slot:activator="{ on }">
                    
                        <v-avatar size="40" v-on="on">
                          <img
                            :src="loginUser.cover"
                            :alt="loginUser.name"
                          >
                        </v-avatar>
                        <v-icon large v-on="on"  class="mr-4 pointer">keyboard_arrow_down</v-icon>
                    
                   </template >
                        <v-card class="mx-auto" min-width="300">
                          <div class="bg-blue">
                            <v-row align="end" class="lightbox white--text pa-2 fill-height">
                              <v-col class="text-center">
                                <v-avatar size="70">
                                    <img
                                      :src="loginUser.cover"
                                      :alt="loginUser.name"
                                    >
                                  </v-avatar>
                                <div class="subheading">{{loginUser.name}}</div>
                                <div class="body-1">{{loginUser.email}}</div>
                              </v-col>
                            </v-row>
                          </div>
                          <v-list>
                            <v-list-item-group >
                              <v-list-item @click="logout"
                                v-for="(item, i) in items"
                                :key="i"
                              >
                                <v-list-item-icon>
                                  <v-icon v-text="item.icon"></v-icon>
                                </v-list-item-icon>
                                <v-list-item-content>
                                  <v-list-item-title v-text="item.text" ></v-list-item-title>
                                </v-list-item-content>
                                <hr>
                              </v-list-item>
                            </v-list-item-group>
                          </v-list>
                        </v-card>
                  </v-menu>
                  <v-btn color="#2F3B59"  tile dark>
                    <v-icon left>library_add</v-icon>
                    <span>Sell</span>
                  </v-btn>
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
        
          items: [
            {
              icon: 'mdi-inbox',
              text: 'My Ads',
            },
            {
              icon: 'mdi-heart',
              text: 'Favorite Ads',
            },
            {
              icon: 'mdi-account-circle',
              text: 'Profile',
            },
            {
              icon: 'mdi-cog',
              text: 'Setting',
            },
            {      
              icon: 'mdi-logout',
              text: 'Logout',
            }
          ],
      }
    },
    methods:{
      logout(){
        axios.post(`/logout`)
             .then(response=>{
               location.reload();
             });
      },
      login(){
        EventBus.$emit('changeDialog', true);
      }
    },
    mounted(){
      //console.log(this.$name);
    }
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