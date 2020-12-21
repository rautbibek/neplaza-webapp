<template>
    <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">Setting</li>
            </ol>
        </nav>
      <div class="py-5">
          <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
          </v-overlay>
        <v-container>
            <v-row wrap class="px-4">
                <v-col cols="12" xs="12" sm="6" lg="3" md="3">
                      <settingMenu></settingMenu>
                </v-col>
                <v-col cols="12" xs="12" sm="6" lg="9" md="9">
                    <v-card>
                        <v-card-title class="font-weight-bold">Contact Setting</v-card-title>
                        <v-divider></v-divider>
                        <v-row class="p-2">
                            <v-col>
                                <v-card-text class="mt-2">Contact Visibility</v-card-text>
                            </v-col>
                            <v-col>
                                <v-switch v-model="contact_status" :label="label" @change="change_contact_status">Hidden for all </v-switch>
                            </v-col>
                        </v-row>
                        <v-row class="p-2">
                            <v-col>
                                <v-card-text class="mt-2">Contact Number</v-card-text>
                            </v-col>
                            <v-col>
                                <v-btn text color="indigo"> <v-icon small left>phone</v-icon>{{my_data.contact_number}}</v-btn>
                                <div v-if="my_data.phone">
                                  <v-btn v-if="my_data.phone_verified"  color="green" dark text>
                                      <v-icon left>done_all</v-icon>
                                      verified
                                  </v-btn>
                                  <v-btn small v-else color="red" dark text>

                                    <v-icon small left>error</v-icon>  contact number is not verified.
                                  </v-btn>
                                </div>
                            </v-col>
                        </v-row>
                        <v-col cols="12" v-if="my_data.phone" @click="contact_form" md="5" class="text-right" xs="12">
                            <v-btn small color="red" text> <v-icon small left>edit</v-icon>Change contact number </v-btn>
                        </v-col>
                        <v-col cols="12" v-else md="5" @click="contact_form" class="text-right" xs="12">
                            <v-btn small color="success" text><v-icon small left>add</v-icon>add contact number </v-btn>
                        </v-col>
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
        my_data:{},
        user_id:this.loginUser.id,
        contact_status:true,
        overlay:false
      }
    },
    methods:{
        contact_form(){
          EventBus.$emit('profileForm', true);
        },
        userData(){
          this.overlay = true;
            axios.get(`/get/login/user`)
                  .then(response =>{
                      this.my_data = response.data;
                      this.contact_status = this.my_data.hide_contact;
                      this.overlay = false;
                  })
                  .catch();
        },
        change_contact_status(){
            this.overlay= true;
            axios.put(`/user/contact/status`,{
                status: this.contact_status,

            })
                 .then(response=>{
                     this.overlay= false;
                     this.userData();
                 })
                 .catch();
        },




    },
    computed:{
        label(){
            return this.contact_status ? "Hidden for all ": "Visible for all";
        },

    },
    created(){
      EventBus.$on('contactUpdated', (data) => {
          this.userData();
      })
      this.userData();
    }




}
</script>
