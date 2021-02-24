<template>
  <div>
    
    <div >
      <v-overlay :value="overlay">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-overlay>
      <div>
        
        <v-row no-gutters>
          
          <v-col v-if="drawer"
            cols="12"
            :md="drawer ? 2 : 0"
            :sm="3" >
            <settingMenu></settingMenu>
          </v-col>
          <v-col :sm="drawer ? 9 : 12"
            :md="drawer ? 10 : 12"
            class="content-wrapper">
            <nav aria-label="breadcrumb ">
              <ol class="breadcrumb">
                <li class="breadcrumb-item pull-right">
                  <router-link :to="`/`">Home</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Settings</li>
                <li class="breadcrumb-item active" aria-current="page">Change Email</li>
              </ol>
            </nav>
            <div outlined class="pa-8 col-md-8">
              <h4 class=" settings-form-title">
                Change or Verify Email
              </h4>
              <v-alert v-if="message" dense :type="type">
                {{ message }}
              </v-alert>
              <v-form ref="form" v-model="valid" lazy-validation>
                <v-card-subtitle class="alignCenter pl-0">
                  Email
                  <v-tooltip bottom>
                    <template v-slot:activator="{ on, attrs }">
                      <v-icon
                        v-bind="attrs"
                        :color="
                          my_data.email_verified_at ? '#00a2f0' : '#b65454'
                        "
                        class="ml-2"
                        small
                        v-on="on"
                        >{{
                          my_data.email_verified_at
                            ? "mdi-check-decagram"
                            : "error"
                        }}
                      </v-icon>
                    </template>
                    <span>
                      {{
                        my_data.email_verified_at
                          ? "Verified Email Address"
                          : "Email Address not Verified"
                      }}</span
                    >
                  </v-tooltip>
                </v-card-subtitle>
                <v-text-field
                  outlined
                  type="email"
                  v-model="email"
                  :rules="emailRules"
                  append-icon="email"
                  placeholder="Email"
                ></v-text-field>
                <v-col cols="12" class="text-center">
                  <v-btn
                    :loading="loading"
                    dark
                    tile
                    class="settings-submit"
                    color="#19916B"
                    @click="email_verification"
                  >
                    <v-icon left>send</v-icon>
                    send Code
                  </v-btn>
                  
                </v-col>
              </v-form>
            </div>
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
                  <v-text-field
                    type="number"
                    v-model="code"
                    label="Email vefirication Code"
                    counter="5"
                    :rules="[
                      required('VERIFICATION CODE'),
                      minLength('VERIFICATION CODE', 5),
                    ]"
                    outlined
                    clearable
                  ></v-text-field>
                </v-col>
              </v-row>
              <v-divider></v-divider>
              <v-col cols="12" class="text-right">
                <v-btn tile color="indigo" dark @click="verify"> verify </v-btn>
              </v-col>
            </v-form>
          </v-card>
        </v-dialog>
      </div>
    </div>
  </div>
</template>
<script>

import SettingMenu from "./settingMenu";
export default {
  components: { SettingMenu },
  data() {
    return {
      my_data: {},
      drawer:true,
      code: null,
      dialog: false,
      valid: true,
      message: "",
      loading: false,
      overlay: false,
      email: "",
      required(propertyType) {
        return (v) => (v && v.length > 0) || `You must input a ${propertyType}`;
      },
      minLength(propertyType, length) {
        return (v) =>
          (v && v.length >= length) ||
          `${propertyType} must be at least ${length} characters`;
      },
      emailRules: [
        (v) =>
          /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
          "E-mail must be valid",
      ],
    };
  },
  methods: {
    
    userData() {
      
      this.overlay = true;
      axios
        .get(`/get/login/user`)
        .then((response) => {
          this.my_data = response.data;
          this.email = this.my_data.valid_email;
          this.overlay = false;
        })
        .catch();
    },
    verify() {
      if (this.$refs.form.validate()) {
        axios
          .post(`/user/email/veriried/at`, {
            verification_code: this.code,
          })
          .then((response) => {
            if (response.data[0] == "success") {
              this.$toast.success(response.data[1], "success", {
                timeout: 3000,
                position: "topRight",
              });
              this.message = response.data[1];
              this.dialog = false;
              this.overlay = false;
              this.show = true;
              this.userData();
              this.$refs.form.reset();
              return;
            } else {
              this.$toast.error(response.data[1], "error", {
                timeout: 3000,
                position: "topRight",
              });

              this.overlay = false;
              this.show = false;
            }
          })
          .catch((error) => {
            this.overlay = false;
            if (error.response.status === 422) {
              this.$toast.error(
                error.response.data.errors.verification_code[0],
                "error",
                {
                  timeout: 3000,
                  position: "topRight",
                }
              );
            }
          });
      }
    },
    close() {
      this.dialog = false;
      this.$refs.form.reset();
    },
    email_verification() {
      if (this.$refs.form.validate()) {
        this.loading = true;
        axios
          .post(`/user/email/verification`, {
            email: this.email,
          })
          .then((response) => {
            this.type = "success";
            this.message = response.data;
            this.loading = false;
            this.dialog = true;
          })
          .catch((error) => {
            if (error.response.status === 422) {
              this.message = error.response.data.errors.email[0];
              this.type = "error";
              this.loading = false;
            }
          });
      }
    },
  },
  created() {
    this.userData();
  },
};
</script>
