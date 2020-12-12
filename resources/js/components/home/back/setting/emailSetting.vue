<template>
    <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">Setting</li>
                <li class="breadcrumb-item active" aria-current="page">Change Password</li>
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

                    <v-card class="mb-12">
                        <v-card-title>Change Or Verify Email</v-card-title>
                        <v-divider></v-divider>
                        <v-col cols="12">
                            <v-alert v-if="message"
                            dense
                            :type="type"
                            >
                            {{message}}
                        </v-alert>
                        </v-col>
                        <v-form ref="form" v-model="valid" lazy-validation>
                            <v-row class="ma-2">
                            <v-col cols="12" xs="12" md="7">
                                <v-text-field
                                dense
                                type="email"
                                v-model="email"
                                :rules="emailRules"
                                append-icon="email"
                                label="Email"

                            ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="4" xs="12">
                                <v-btn v-if="my_data.email_verified_at"  color="green" dark text>
                                    <v-icon left>done_all</v-icon>
                                    verified
                                </v-btn>
                                <v-btn v-else color="red" dark text>
                                    <v-icon left>error</v-icon>
                                    Email is not verified.
                                </v-btn>
                            </v-col>
                            </v-row>
                            <v-col cols="12">
                                <v-btn :loading="loading" dark tile  @click="email_verification" color="indigo">
                                    <v-icon left>send</v-icon>
                                    send Code
                                </v-btn>

                            </v-col>
                        </v-form>
                    </v-card>
                </v-col>
            </v-row>
            <v-dialog v-model="dialog" persistent max-width="430">
              <v-card tile>
                  <v-card-title class="text-right">
                    Verification Code
                  <v-spacer></v-spacer>
                  <v-btn x-small fab @click="close"><v-icon>close</v-icon></v-btn>
                  </v-card-title>
                  <v-divider></v-divider>
                  <v-form ref="form" v-model="valid" lazy-validation>

                      <v-row class="ma-3">
                        <v-col cols="12">
                          <v-text-field style="border-radius:0px; margin-bottom:20px"
                              type="number"
                              v-model="code"
                              label="Email vefirication Code"
                              counter="5"
                              :rules="[required('VERIFICATION CODE'),minLength('VERIFICATION CODE',5)]"
                              outlined
                              clearable
                          ></v-text-field>
                        </v-col>

                      </v-row>
                    <v-divider></v-divider>
                    <v-col cols="12" class="text-right">


                        <v-btn tile color="indigo" dark  @click="verify">

                          verify
                        </v-btn>
                    </v-col>
                  </v-form>
              </v-card>
            </v-dialog>
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
            code:null,
            dialog:false,
            valid:true,
            message:'',
            loading:false,
            overlay : false,
            email:'',
            required(propertyType){
                return v => v && v.length > 0 || `You must input a ${propertyType}`
            },
            minLength(propertyType,length){
               return v => v && v.length >= length || `${propertyType} must be at least ${length} characters`
            },
            emailRules: [
                 v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
            ],
        }
    },
    methods:{
      userData(){
        this.overlay = true;
          axios.get(`/get/login/user`)
                .then(response =>{
                    this.my_data = response.data;
                    this.email = this.my_data.valid_email;
                    this.overlay = false;
                })
                .catch();
      },
      verify(){
        if(this.$refs.form.validate()){
        //this.overlay= true
          axios.post(`/user/email/veriried/at`,{
            verification_code : this.code,
          }).then(response =>{
            if(response.data[0] == 'success'){
              this.$toast.success(response.data[1],'success',{
                timeout:3000,
                position: 'topRight',
              });
              this.message = response.data[1];
              this.dialog = false;
              this.overlay = false;
              this.show = true;
              this.userData();
              this.$refs.form.reset();
              return;
            }else{
              this.$toast.error(response.data[1],'error',{
                timeout:3000,
                position: 'topRight',
              });

              this.overlay = false;
              this.show = false;
            }

          })
            .catch(error=>{
                this.overlay = false;
                if (error.response.status === 422) {
                this.$toast.error(error.response.data.errors.verification_code[0],'error',{
                  timeout:3000,
                  position: 'topRight',
                });
              }
            });
          }
      },
      close(){
          this.dialog= false;
          this.$refs.form.reset();
        },
      email_verification(){
            if(this.$refs.form.validate()){
                this.loading = true;
                axios.post(`/user/email/verification`,{
                    email:this.email,
                })
                .then(response=>{
                    this.type = "success"
                    this.message = response.data;
                    this.loading= false;
                    this.dialog = true;
                })
                .catch(error=>{
                    if(error.response.status === 422){
                        this.message = error.response.data.errors.email[0];
                        this.type="error";
                        this.loading= false;
                    }
                });
            }
        }
    },
    created(){
      this.userData()
    }

}
</script>
