<template>
    <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">Setting</li>
                <li class="breadcrumb-item active" aria-current="page">Account Setting</li>
            </ol>
        </nav>
      <div class="py-5">
        
        <v-container>
            <v-row wrap class="px-4">
                <v-col cols="12" xs="12" sm="6" lg="3" md="3">
                      <settingMenu></settingMenu>
                </v-col>
                <v-col cols="12" xs="12" sm="6" lg="9" md="9"> 
                    <v-card class="text-center " height="220px">
                        <v-card-title>Account Setting</v-card-title>
                        <v-divider></v-divider>
                         <v-btn class="ma-5" :loading="loading" tile color="indigo" dark @click="deactivate">
                             <v-icon left>mdi-account-circle</v-icon>
                             Deactivate account
                        </v-btn>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
      </div>
    </div>
</template>
<script>
import SettingMenu from './settingMenu';
export default {
    components:{SettingMenu},
    data(){
      return{
        loading:false,
      }
    },
    methods:{
        
        
        deactivate(){
            if(confirm('are you sure to want do deactivate your account ? once you deactivate your account you won`t be able to recover yor data.')){
            this.loading= true;
            axios.put(`/user/deactivate/account`)
                 .then(response =>{
                     this.loading= false;
                     return this.logout();
                 }).catch();
                  
            }
           
        },
        logout(){
            axios.post(`/logout`)
            .then(response =>{
                location.reload();
            })
        }
        

    },

}
</script>