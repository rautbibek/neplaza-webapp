<template>
    <v-card  flat tile style="border:1px solid black">

          <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
          </v-overlay>
          <v-card-title class="font-weight-bold">
             Edit Information
          </v-card-title>
          <div class="form-seperator"></div>
          <div class="mt-4">

            <v-form ref="form" v-model="valid" lazy-validation>
                <v-card-subtitle class="font-weight-bold">
                   Display Name
                </v-card-subtitle>
                <v-col cols="12" md="8" xs="10" class="mx-2">
                  <v-text-field style="border-radius:0px; margin-bottom:20px"
                      v-model="name"
                      label="Name"
                      counter="20"
                      :rules="[required('name'),minLength('name',5),maxLength('name',20)]"
                      outlined
                      clearable
                  ></v-text-field>
                </v-col>
                <div class="form-seperator"></div>
                <v-card-subtitle class="font-weight-bold">
                   Contact number
                </v-card-subtitle>
                <v-col>
                  <v-row no-gutters>
                    <v-col cols="12" md="8" xs="10" class="mx-2">
                      <v-text-field style="border-radius:0px;" @click="addContact"
                          type="number"

                          label="Contact Number"
                          counter="20"
                          :value="userData.phone"
                          readonly
                          outlined

                      ></v-text-field>
                    </v-col>
                    <v-col style="margin-bottom:10px">

                        <div v-if="userData.phone">
                          <v-btn v-if="userData.phone_verified"  color="green" dark text>
                              <v-icon left>done_all</v-icon>
                              verified
                          </v-btn>
                          <v-btn small v-else color="red" dark text>

                            <v-icon small left>error</v-icon>  contact number is not verified.
                          </v-btn>
                        </div>
                    </v-col>
                  </v-row>
                </v-col>
                <v-col cols="12" md="11" xs="12" class="text-right mb-2">
                  <v-btn v-if="userData.phone" x-small color="red" text router to="/user/setting">
                    <v-icon x-small left>edit</v-icon>
                    edit contact number
                  </v-btn>
                  <v-btn v-else x-small color="green" text router to="/user/setting">
                    <v-icon x-small left>add</v-icon>
                    add contact number
                  </v-btn>
                </v-col>

                <div class="form-seperator"></div>
                <v-card-subtitle class="font-weight-bold">
                   Email Address
                </v-card-subtitle>
                <v-col>
                  <v-row no-gutters>
                    <v-col cols="12" md="8" xs="10" class="mx-2">
                      <v-text-field style="border-radius:0px;"


                          label="Email"
                          counter="30"
                          :value="userData.valid_email"
                          readonly
                          outlined

                      ></v-text-field>
                    </v-col>
                    <v-col>
                        <v-btn v-if="userData.email_verified_at"  color="green" dark text>
                            <v-icon left>done_all</v-icon>
                            verified
                        </v-btn>
                        <v-btn v-else color="red" dark text>
                            <v-icon left>error</v-icon>
                            Email is not verified.
                        </v-btn>
                    </v-col>
                  </v-row>
                </v-col>
                <v-col cols="12" md="11" xs="12" class="text-right mb-2">
                  <v-btn x-small color="red" text router to="/user/email/setting">
                    <v-icon x-small left>edit</v-icon>
                    add or edit email address
                  </v-btn>
                </v-col>

                <div class="form-seperator"></div>
                <v-card-subtitle class="font-weight-bold">
                   Address
                </v-card-subtitle>
                <v-col cols="12" md="8" xs="10" class="mx-2">
                  <v-autocomplete style="border-radius:0px; margin-bottom:20px"
                  v-model="district"
                  :items='city'
                  :item-text="'name'"
                  :item-value="'id'"
                  :rules="[v => !!v || 'District is required']"
                  label="District"
                  clearable
                  outlined
                  @change="getNhood"
                  ></v-autocomplete>
                </v-col>

                <v-col cols="12" md="8" xs="10" class="mx-2">
                  <v-autocomplete style="border-radius:0px; margin-bottom:10px"
                  v-model="nhood"
                  :items='localArea'
                  :item-text="'name'"
                  :item-value="'id'"
                  :rules="[v => !!v || 'Metro/Municipility/VDC is required']"
                  label="Metro/Municipility/VDC"
                  clearable
                  outlined
                  :loading ="loading"
                  >
                  </v-autocomplete>
                </v-col>

              <div class="form-seperator"></div>
              <v-col cols="12" md="9" xs="12">
                  <v-btn small dark color="indigo"  @click="submit">Update PROFILE</v-btn>
              </v-col>
            </v-form>
      </div>
</v-card>
</template>
<script>
export default {
    props:['userData'],
    data(){
        return{
            loading : false,
            valid:true,
            overlay:false,

            district:this.loginUser.city_id,
            name : this.loginUser.name,
            email : this.loginUser.valid_email,
            contact: this.loginUser.phone,
            about:this.loginUser.about,
            nhood:this.loginUser.nhood_id,
            city:[],
            localArea:[],
            required(propertyType){
               return v => v && v.length > 0 || `you must input a ${propertyType}`
            },
            minLength(propertyType,length){
               return v => v && v.length >= length || `${propertyType} must be at least ${length} characters`
            },
            maxLength(propertyType,length){
               return v => v && v.length <= length || `${propertyType} must be less than ${length} characters`
            },


        }
    },
    methods:{
        addContact(){
          EventBus.$emit('profileForm', true);
        },
        submit(){
            if(this.$refs.form.validate()){
                this.overlay = true;
                axios.put(`/update/profile`,{
                    name : this.name,
                    nhood:this.nhood,
                    district: this.district,
                })
                     .then(response =>{
                         this.overlay = false;
                         this.$toast.success(response.data,'success',{
                         timeout:3000,
                         position: 'topRight',
                         });
                         EventBus.$emit('updateUser',true);

                         EventBus.$emit('loadUser');
                     })
                     .catch(error=>{
                         if(error.response.status == 422){
                             this.overlay= false;
                             this.$toast.error(error.response.data.errors.email[0],'error',{
                                timeout:3000,
                                position: 'topRight',
                            });
                         }

                     });
            }
        },

        getCity(){
            axios.get( `/all/city`)
                 .then(response =>{
                     this.city = response.data;

                     this.getNhood();
                 })
                 .catch();
        },

        getNhood(){
            this.loading= true;
            axios.get(`/get/nhood/${this.district}`)
                 .then(response => {
                     this.localArea = response.data;
                     this.loading= false;

                 })
                 .catch()
        },

    },
    created(){
        return this.getCity();
    }
}
</script>
