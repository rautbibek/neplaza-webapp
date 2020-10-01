<template>
    <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav>
        <div class="py-3">
        <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
        <v-container>
            <div class="container">
                <v-layout row wrap class="px-2">
                    <v-flex xs12 sm5 md4 lg3 class="m-2">
                        <v-card tile class="pa-5 text-center">

                          <v-col class="" style="padding:0px">
                              <v-responsive>
                                  <v-avatar size="120">
                                  <img
                                      :src="profile.cover"
                                      :alt="profile.name"
                                  >
                                  </v-avatar>
                              </v-responsive>
                          </v-col>
                            <h6 class="mt-2">{{profile.email}}</h6>
                            <p><small>{{profile.register_date}}</small></p>

                             <v-btn @click="dialog=true" text x-small color="primary">
                                 <v-icon left x-small>mdi-pencil</v-icon>
                                 change profile
                            </v-btn>
                        </v-card>
                        <!-- dialog -->
                            <v-dialog v-model="dialog" persistent  max-width="450">
                                <v-card>
                                    <v-card-title class="text-right">
                                    select profile picture
                                    <v-spacer></v-spacer>
                                    <v-btn x-small fab @click="dialog = false"><v-icon>close</v-icon></v-btn>
                                    </v-card-title>

                                    <v-divider></v-divider>

                                    <v-form class="px-3" ref="form" v-model="valid" lazy-validation>

                                            <v-col class="text-center">

                                                    <v-avatar class="border" v-if="url" size="100">
                                                    <img
                                                        :src="url"
                                                        :alt="url"
                                                    >
                                                  </v-avatar>

                                            </v-col>

                                            <v-col cols="12">
                                                <v-file-input
                                                @change="getImage"
                                                type="file"
                                                show-size
                                                v-model="image"
                                                accept="image/png, image/jpeg, image/bmp"
                                                label="Profile Pictrue"
                                                :rules="[select('image')]"

                                                ></v-file-input>
                                            </v-col>
                                    </v-form>
                                    <v-card-actions>
                                    <v-spacer></v-spacer>

                                    <v-btn
                                        color="green darken-1"
                                        dark
                                        tile
                                        @click="save"
                                    >
                                        update
                                    </v-btn>
                                    </v-card-actions>
                                </v-card>
                                </v-dialog>
                        <v-card tile class="pa-3 mt-3">
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

                        <v-card tile class="pa-3 mt-3">
                            <h5 class="m-2 text-center"><i class="fa fa-map-marker"> </i> Address Location </h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6"> Located District :</div>
                                <div class="col-md-6">
                                    <span v-if="profile.city">{{profile.city.name}}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">Metro/Municipility/VDC :</div>
                                <div class="col-md-6">
                                    <span v-if="profile.nhood">{{profile.nhood.name}}</span>
                                </div>
                            </div>
                        </v-card>


                    </v-flex>
                    <v-flex xs12 sm6 md7 lg8 class="m-2">
                        <profile-form :userData="profile"></profile-form>

                        <div v-if="checkCompletion" >
                          <ProfileCompletion ></ProfileCompletion>
                        </div>
                    </v-flex>
                </v-layout>
            </div>
        </v-container>
      </div>
    </div>
</template>
<script>
import ProfileCompletion from './profile/complete_profile';
export default {
    components:{
      ProfileCompletion,
    },
    data(){
        return{
            url:'',
            dialog:false,
            valid:true,
            image:[],
            show:true,
            profile:{},
            overlay:false,
            select(propertyType) {
                return value => !value || value.size < 5000000 || `${propertyType} size should be less than 2 MB!`
            },
        }
    },
    methods:{
        getImage(e){
            let file = e;

            this.url = URL.createObjectURL(file);

        },
        save(){
             if (this.$refs.form.validate()) {
                 this.overlay= true;
                 const formData = new FormData();
                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                };
            formData.append("_method", "put");
            formData.append('image', this.image);
            axios.post(`/update/cover`,formData, config)
                 .then(response=>{
                     this.userProfile();
                     this.overlay = false;
                        this.dialog = false;
                        this.$toast.success(response.data, 'success', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                 })
                 .catch(error=>{
                     if (error.response.status === 422) {
                     this.overlay = fale
                     if (error.response.data.errors.image.length>0) {
                        this.$toast.error(error.response.data.errors.image[0],'error', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                        return
                     }

                    }
                    this.overlay = false;
                 });
             }
            this.overlay = false;
        },

        userProfile(){
            this.overlay =true;
            axios.get(`/get/login/user/`)
                  .then(response =>{
                      this.profile = response.data;
                      this.overlay = false;
                  })
                  .catch();
        }
    },
    computed:{
      checkCompletion(){
         return  !this.profile.completion;

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
