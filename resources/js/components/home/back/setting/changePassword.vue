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

        <v-container>
            <v-row wrap class="px-4">
                <v-col cols="12" xs="12" sm="6" lg="3" md="3">
                      <settingMenu></settingMenu>
                </v-col>
                <v-col cols="12" xs="12" sm="6" lg="9" md="9">

                    <v-card class="mb-12">
                        <v-card-title>Change Password</v-card-title>
                        <v-divider></v-divider>
                        <v-col cols="12">
                            <v-alert v-if="message.length"
                            dense
                            :type="message[0]"
                            >
                            {{message[1]}}
                        </v-alert>
                        </v-col>
                        <v-form ref="form" v-model="valid" lazy-validation>

                                <v-col cols="12" md="8" xs="12">
                                    <v-text-field style="border-radius:0px;"

                                        outlined
                                        :append-icon="value ? 'visibility' : 'visibility_off'"
                                        @click:append="() => (value = !value)"
                                        :type="value ? 'password' : 'text'"
                                        v-model="old_password"
                                        :rules="[required('Old Password'),minLength('Old Password',6)]"
                                        label="Old Password"


                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" md="8" xs="12">
                                    <v-text-field style="border-radius:0px;"
                                        outlined

                                        :append-icon="value1 ? 'visibility' : 'visibility_off'"
                                        @click:append="() => (value1 = !value1)"
                                        :type="value1 ? 'password' : 'text'"
                                        v-model="password"
                                        :rules="[required('New Password'),minLength('New Password',6)]"
                                        label="New Password"

                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12" md="8" xs="12">
                                    <v-text-field style="border-radius:0px;"
                                        outlined

                                        :append-icon="value2 ? 'visibility' : 'visibility_off'"
                                        @click:append="() => (value2 = !value2)"
                                        :type="value2 ? 'password' : 'text'"
                                        v-model="confirm_password"
                                        :rules="[required('Confirm Password'),passwordConfirmationRule,minLength('Confirm Password',6)]"
                                        label="Confirm Password"

                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-btn :loading="loading" dark tile color="indigo" @click="updatePassword">
                                        <v-icon left>vpn_key</v-icon>
                                        Update password
                                    </v-btn>
                                </v-col>

                        </v-form>
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
            value: String,
            value1: String,
            value2: String,
            valid:true,
            loading : false,

            message:[],
            old_password:'',
            password:'',
            confirm_password:'',
            required(propertyType){
             return v => v && v.length > 0 || `You must input a ${propertyType}`
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
        updatePassword(){

            if(this.$refs.form.validate()){
                this.loading= true;
                axios.post(`/change/user/password`,{
                    old_password:this.old_password,
                    password:this.password,
                    password_confirmation:this.confirm_password
                })
                 .then(response=>{
                    this.message = response.data;
                     this.loading = false;
                 })
                 .catch(error=>{
                     this.loading = false;
                 });
            }
        },
    },
    computed: {
        passwordConfirmationRule() {
            return () => (this.password === this.confirm_password) || 'Password must match'
        },
    }
}
</script>
