<template>
    <div class="row no-gutters">
        <div class="col-3 text-center">

              <notification></notification>
        </div>
        <div class="col-4 text-right">
          <v-menu offset-y nudge-bottom="15" open-on-click close-on-content-click transition="scale-transition">
           <template v-slot:activator="{ on }">
              <v-avatar size="38" color="grey" class="profile" v-on="on">
                <img 
                  :src="loginUser.cover"
                  :alt="loginUser.name"
                >
              </v-avatar>
              <v-icon v-on="on"  class="mr-4 pointer">keyboard_arrow_down</v-icon>    
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
                      <v-list-item
                        v-for="(item, i) in items"
                        :key="i"
                        router :to="item.url"
                      >
                        <v-list-item-icon>
                          <v-icon v-text="item.icon"></v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                          <v-list-item-title v-text="item.text" ></v-list-item-title>
                        </v-list-item-content>
                        <hr>
                      </v-list-item>
                      <v-list-item @click="logout">
                        <v-list-item-icon>
                          <v-icon>mdi-logout</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                          <v-list-item-title >Logout</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </v-list-item-group>
                  </v-list>
                </v-card>
          </v-menu>
        </div>
          
        
            
          <div class="col-3">
            <v-btn color="#2F3B59" tile dark router :to='`/user/create/ads`'>
            <v-icon left>library_add</v-icon>
            <span>Sell</span>
          </v-btn>
          </div>
          
          
          
    </div>
</template>
<script>
  export default {
    data () {
      return {
        
          items: [
            {
              icon: 'library_add',
              text: 'Create New Ads',
              url : '/user/create/ads'
            },

            {
              icon: 'mdi-inbox',
              text: 'My Ads',
              url : '/user/myads'
            },
            {
              icon: 'mdi-heart',
              text: 'Favorite Ads',
              url : '/user/favorite'
            },
            {
              icon: 'mdi-account-circle',
              text: 'Profile',
              url : '/user/profile'
            },
            {
              icon: 'mdi-cog',
              text: 'Setting',
              url : '/user/setting'
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
    },
  }
</script>