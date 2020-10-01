<template>
  <v-row justify="center" v-if="!loginUser.completion">
    <v-dialog v-model="dialog" persistent scrollable max-width="550px">

      <v-card>
        <v-toolbar dark color="primary">

          <v-toolbar-title>Set a new password</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn x-small fab @click="dialog = false" text><v-icon>close</v-icon></v-btn>
        </v-toolbar>
              <v-alert v-if="error_message"
                  dense
                  type="error"
                  >
                  {{error_message}}
              </v-alert>
              <v-card flat class="my-5">
                <v-card-text>
                  <v-form ref="form" v-model="valid" lazy-validation>
                    <v-col cols="12">
                      <v-text-field
                          dense
                          style="border-radius:0px;"
                          :append-icon="value ? 'visibility' : 'visibility_off'"
                          @click:append="() => (value = !value)"
                          :type="value ? 'password' : 'text'"
                          v-model="password"
                          :rules="[required('password'),minLength('password',6)]"
                          label="password"
                          outlined
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12">
                      <v-text-field
                          dense
                          style="border-radius:0px;"
                          :append-icon="value1 ? 'visibility' : 'visibility_off'"
                          @click:append="() => (value1 = !value1)"
                          :type="value1 ? 'password' : 'text'"
                          v-model="confirm_password"
                          :rules="[required('Confirm Password'),passwordConfirmationRule,minLength('Confirm Password',6)]"
                          label="Confirm Password"
                          outlined
                      ></v-text-field>
                    </v-col>
                  </v-form>

                  <v-col cols="12" class="text-right ">
                    <v-btn color="primary" dark @click="save"> <v-icon x-small left>save</v-icon> save </v-btn>
                  </v-col>
                </v-card-text>
              </v-card>

      </v-card>
    </v-dialog>

  </v-row>
</template>

<script>
  export default {
    props:['comp'],
    data () {

      return {
        error_message:'',
        value:String,
        value1:String,
        loading: false,
        valid:true,
        dialog: true,

        password:'',
        confirm_password:'',
        message:'',
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
       save(){
        if(this.$refs.form.validate()){
          this.loading = true;

          axios.post(`/user/initial/update`,{
            'password' : this.password,
            'confirm_password': this.confirm_password,
          })
              .then(response=>{
                this.$toast.success(response.data,'message', {
                    timeout: 3000,
                    position: 'topRight',
                });
                this.dialog= false;
                this.loading = false;

              })
              .catch(error=>{
                if(error.response.status === 422){
                  this.message = "";
                  this.loading = false;
                }
                this.$toast.error(error.response.data.message, 'Error', {
                    timeout: 3000,
                    position: 'topRight',
                });

              });
        }
      }
    },

    computed: {
        passwordConfirmationRule() {
            return () => (this.password === this.confirm_password) || 'Password must match'
        },
    },
  }
</script>
