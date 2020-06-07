<template>
    <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav>
        <div class="py-3">
          
        <v-container>
            <div class="container">
                <v-layout row wrap class="px-4">
                    <v-flex xs12 sm5 md4 lg3 class="m-2">
                        <v-card tile class="pa-5 text-center">
                            <h4 class="mb-2">{{profile.name}}</h4>
                            <v-avatar size="100">
                                <img
                                    :src="profile.cover"
                                    :alt="profile.name"
                                >
                            </v-avatar>
                            <h6 class="mt-2">{{profile.email}}</h6>
                            <small>{{profile.register_date}}</small>
                        </v-card>
                        <v-card tile class="pa-2 mt-3">
                            <h5 class="m-2 text-center"><i class="fa fa-phone"> </i> Contact Detail</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">  Contact Number :</div>
                                <div class="col-md-6">{{profile.contact_number}}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">Contact Status :</div>
                                <div class="col-md-6">{{profile.contact_status}}</div>
                            </div>
                        </v-card>

                        <v-card tile class="pa-2 mt-3">
                            <h5 class="m-2 text-center"><i class="fa fa-map-marker"> </i> Address Location </h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6"> Located District :</div>
                                <div class="col-md-6">{{profile.located_city}}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">Metro/Municipility/VDC :</div>
                                <div class="col-md-6">{{profile.located_metro}}</div>
                            </div>
                        </v-card>
                        <v-card tile class="pa-2 mt-3">
                            <h5 class="m-2 text-center"><i class="fa fa-map-marker"> </i> About </h5>
                            <hr>
                            <p>{{profile.about}}</p>
                        </v-card>
                        
                    </v-flex>
                    <v-flex xs12 sm6 md7 lg8 class="m-2">
                        <profile-form></profile-form>
                    </v-flex>
                </v-layout>
            </div>
        </v-container>
      </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            profile:{},
        }
    },
    methods:{
        userProfile(){
            axios.get(`/get/login/user/`)
                  .then(response =>{
                      this.profile = response.data;
                  })
                  .catch();
        }
    },
    created(){
        if(!this.loggedIn){
                this.$router.push("/");
                EventBus.$emit('changeDialog', true);
                return;
            }
        return this.userProfile();
    },
    mounted() {
        EventBus.$on('updateUser',(data)=>{
        return this.userProfile();
      })
    },
}
</script>