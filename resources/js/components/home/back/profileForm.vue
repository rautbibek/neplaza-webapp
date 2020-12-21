<template>
  <v-row justify="center">
    <v-overlay :value="overlay">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <!-- <v-btn x-small fab @click="dialog=true"><v-icon>contact</v-icon></v-btn> -->
    <v-dialog v-model="dialog" persistent max-width="430">
      <v-card tile>
          <v-card-title class="text-right">
            Contact Number
          <v-spacer></v-spacer>
          <v-btn x-small fab @click="close"><v-icon>close</v-icon></v-btn>
          </v-card-title>
          <v-divider></v-divider>
          <v-form ref="form" v-model="valid" lazy-validation>
              <v-col cols="12" v-if="show">
                <v-row no-gutters class="ma-3">
                  <v-col cols="3">
                    <v-text-field
                        outlined
                        readonly
                        placeholder="+977"
                        style="border-radius:0px; margin-bottom:20px"
                      ></v-text-field>
                  </v-col>
                  <v-col cols="9" md="9" sm="9">

                    <v-text-field style="border-radius:0px; margin-bottom:20px"
                        type="number"
                        v-model="contact"
                        label="Contact Number"
                        counter="10"
                        :rules="[required('Contact Number'),minLength('Contact Number',9),maxLength('Contact Number',10)]"
                        outlined
                        clearable
                    ></v-text-field>
                  </v-col>
                </v-row>
              </v-col>
              <v-row class="ma-3">
                <v-col cols="12" v-if="!show">
                  <v-text-field style="border-radius:0px; margin-bottom:20px"
                      type="number"
                      v-model="otp"
                      label="OTP CODE"
                      counter="5"
                      :rules="[required('OTP CODE'),minLength('OTP CODE',5)]"
                      outlined
                      clearable
                  ></v-text-field>
                </v-col>
                <v-col cols="12" class="text-right" v-if="!show">
                  <v-btn text x-small color="indigo" v-if="!show"  @click="resend">
                    change contact number <v-icon x-small right>edit</v-icon>
                  </v-btn>
                </v-col>
              </v-row>
            <v-divider></v-divider>
            <v-col cols="12" class="text-right">
                <v-btn tile color="indigo" dark v-if="show"  @click="submit">
                  <v-icon small left>send</v-icon>
                  send otp
                </v-btn>

                <v-btn tile color="indigo" dark v-if="!show"  @click="verify">
                  <v-icon small left>contact</v-icon>
                  verify
                </v-btn>

            </v-col>
          </v-form>
      </v-card>
    </v-dialog>

  </v-row>
</template>

<script>
  export default {
    data () {
      return {
        overlay:false,
        contact:'',
        show:true,
        otp:'',
        loading : false,
        valid:true,
        overlay:false,
        dialog: false,
           required(propertyType){
               return v => v && v.length > 0 || `you must input a ${propertyType}`
            },
            minLength(propertyType,length){
               return v => v && v.length >= length || `${propertyType} must be at least ${length} characters`
            },
            maxLength(propertyType,length){
               return v => v && v.length <= length || `${propertyType} must be less than ${length} characters`
            },
        items: [
          {
            src: '/image/back.jpg',
          },
        ],
      }
    },
    methods:{
        close(){
          this.dialog= false;
          this.$refs.form.reset();
        },
        resend(){
          this.show = true;
          this.$refs.form.reset();
        },
        verify(){
          if(this.$refs.form.validate()){
          this.overlay= true
            axios.put(`/update/contact`,{
              otp : this.otp,
            }).then(response =>{
              if(response.data[0] == 'success'){
                this.$toast.success(response.data[1],'success',{
                  timeout:3000,
                  position: 'topRight',
                });
                this.dialog = false;
                this.overlay = false;
                this.show = true;
                EventBus.$emit('contactUpdated', this.contact);
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
                  this.$toast.error(error.response.data.errors.contact_number[0],'error',{
                    timeout:3000,
                    position: 'topRight',
                  });
                }
              });
            }
        },
        submit(){
          if(this.$refs.form.validate()){
          this.overlay= true
            axios.post(`/send/otp`,{
              contact_number : this.contact,
            }).then(response =>{
              this.overlay = false;
               if(response.data[0] == 'success'){
                 this.show = false;
                 this.$toast.success(response.data[1],'success',{
                   timeout:3000,
                   position: 'topRight',
                 });

               }
                 this.$toast.info(response.data[1],'message',{
                   timeout:3000,
                   position: 'topRight',
                 });

            })
              .catch(error=>{
                  this.overlay = false;
                  if (error.response.status === 422) {
                  this.$toast.error(error.response.data.errors.contact_number[0],'error',{
                    timeout:3000,
                    position: 'topRight',
                  });
                }
              });
            }
        }
    },
    created(){
      EventBus.$on('profileForm',(data)=>{
        this.dialog = data;
      })
    }
  }
</script>
