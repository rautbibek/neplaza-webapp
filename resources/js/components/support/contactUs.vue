<template>
    <div>
      <nav aria-label="breadcrumb ">
          <ol class="breadcrumb ">
              <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
              <li class="breadcrumb-item active" aria-current="page">Contact US</li>
          </ol>
      </nav>

      <div>
          <v-container>
            <v-card tile flat >
              <v-row>
                <v-col cols="12" md="4" xs="12">
                  <v-card tile elevation="12">
                      <v-fab-transition>
                        <v-btn
                          color="rgb(47 59 89)"
                          dark
                          absolute
                          top
                          right
                          fab
                        >
                          <v-icon>phone</v-icon>
                        </v-btn>
                      </v-fab-transition>
                      <v-card-text>
                        <v-card-title>Call US</v-card-title>

                        <div class="text--primary">
                          <a href="tel:9863756278">+977-9863756278</a>
                          <br>
                          <a href="tel:9813074153">+977-9813074153</a>

                        </div>
                      </v-card-text>
                  </v-card>
                </v-col>
                <v-col cols="12" md="4" xs="12">
                  <v-card tile elevation="12">
                      <v-fab-transition>
                        <v-btn
                          color="rgb(47 59 89)"
                          dark
                          absolute
                          top
                          right
                          fab
                        >
                          <v-icon>email</v-icon>
                        </v-btn>
                      </v-fab-transition>
                      <v-card-text>

                        <v-card-title>E-mail US</v-card-title>

                        <div class="text--primary">
                          <a href="mailto:rautbibek47@gmail.com">rautbibek47@gmail.com</a>,<br>
                          <a href="mailto:aiskabasnet@gmail.com">aiskabasnet@gmail.com</a>

                        </div>
                      </v-card-text>
                  </v-card>
                </v-col>
                <v-col cols="12" md="4" xs="12">
                  <v-card tile elevation="12">
                      <v-fab-transition>
                        <v-btn
                          color="rgb(47 59 89)"
                          dark
                          absolute
                          top
                          right
                          fab
                        >
                          <v-icon>home</v-icon>
                        </v-btn>
                      </v-fab-transition>
                      <v-card-text>

                        <v-card-title>
                          Address
                        </v-card-title>

                        <div class="text--primary">
                          Naya Basti, Bouddha-6,<br>
                          Kathmandu,Nepal
                        </div>
                      </v-card-text>
                  </v-card>
                </v-col>
              </v-row>

                <v-card tile elevation="12">
                  <v-row>
                    <v-col cols="12" md="6" lg="6" sm="6" xs="12">
                      <v-card-title>OFFICE LOCATION</v-card-title>
                      <v-card-subtitle>Find us here.</v-card-subtitle>

                      <v-col>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d7064.117842200193!2d85.36332699999998!3d27.715466999999993!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2snp!4v1599734060945!5m2!1sen!2snp"
                        width="100%" height="400" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                      </v-col>
                    </v-col>
                    <v-col cols="12" class="border-left" md="6" lg="6" sm="6" xs="12">
                      <v-card-title>CONTACT FORM</v-card-title>
                      <v-card-subtitle>Ask if you have any queries.</v-card-subtitle>

                      <v-form ref="form" v-model="valid">
                          <v-col cols="12">
                            <v-text-field
                              v-model="name"
                              :rules="[required('Full Name'),maxLength('Name',50)]"
                              dense
                              label="Full Name"
                              filled
                            ></v-text-field>
                          </v-col>
                          <v-col cols="12" >
                            <v-text-field
                              dense
                              v-model="email"
                              :rules="emailRules"
                              label="email"
                              filled
                            ></v-text-field>
                          </v-col>
                          <v-col cols="12">
                            <v-text-field
                              dense
                              :rules="[required('Subject'),maxLength('Subject',190)]"
                              v-model="subject"
                              label="Subject"
                              filled
                            ></v-text-field>
                          </v-col>
                          <v-col cols="12">
                            <v-textarea
                              dense
                              filled
                              :rules="[required('message')]"
                              v-model="message"
                              name="input-7-4"
                              label="Message"
                            ></v-textarea>
                          </v-col>
                          <v-col cols="12">
                            <v-btn
                              tile
                              :loading="loading"
                              color="rgb(47 59 89)"
                              dark
                              @click="send"
                            >
                              Send
                              <v-icon right dark>message</v-icon>
                            </v-btn>
                            <!-- <v-btn tile large dark color="rgb(47 59 89)" @click="send">
                              <v-icon left>message</v-icon> send</v-btn> -->
                          </v-col>
                      </v-form>
                    </v-col>
                  </v-row>
                </v-card>

            </v-card>
          </v-container>
      </div>

    </div>
</template>

<script>
  export default {
    data () {
      return {
        valid:true,
        loading: false,
        name:'',
        email:'',
        subject:'',
        message:'',
        required(propertyType){
          return v => v && v.length > 0 || `You must input a ${propertyType}`
        },

        emailRules: [
          v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
        ],
        minLength(propertyType,length){
          return v => v && v.length >= length || `${propertyType} must be at least ${length} characters`
        },
        maxLength(propertyType,length){
          return v => v && v.length <= length || `${propertyType} must be less than ${length} characters`
        },

      }
    },
    methods: {
      send(){
          if(this.$refs.form.validate()){
            this.loading = true;
            axios.post(`/send/contact/message`,{
            message: this.message,
            name: this.name,
            email:this.email,
            subject:this.subject,
          }).then(response=>{
            this.$toast.success(response.data,'message', {
                timeout: 3000,
                position: 'topRight',
            });
            this.loading = false;
            this.$refs.form.reset();
          }).catch(error=>{
            this.loading = false;
            if(error.response.status === 422){

              this.loading = false;
              if(error.response.data.errors.email){
                this.error_message = error.response.data.errors.email[0];
                return;
              }


            }
            if(error.response.data.errors.email){
              this.error_message = error.response.data.message;
              return;
            }
          });
        }
      }
    }


  }
</script>
