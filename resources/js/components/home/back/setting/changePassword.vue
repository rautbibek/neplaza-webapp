<template>
  <div>
    <nav aria-label="breadcrumb ">
      <ol class="breadcrumb">
        <li class="breadcrumb-item pull-right">
          <router-link :to="`/`">Home</router-link>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Settings</li>
        <li class="breadcrumb-item active" aria-current="page">
          Change Password
        </li>
      </ol>
    </nav>
    <div class="py-5">
      <v-container class="container-wrapper">
        <v-row wrap>
          <v-col cols="12" xs="12" sm="5" md="3" class="menu-box-wrapper pt-0">
            <settingMenu></settingMenu>
          </v-col>
          <v-col cols="12" xs="12" sm="7" md="9">
            <v-card outlined class="pa-8">
              <h4 class="text-center settings-form-title">Change Password</h4>
              <v-alert v-if="message.length" dense :type="message[0]">
                {{ message[1] }}
              </v-alert>
              <v-form ref="form" v-model="valid" lazy-validation>
                <v-text-field
                  outlined
                  :append-icon="value ? 'visibility' : 'visibility_off'"
                  @click:append="() => (value = !value)"
                  :type="value ? 'password' : 'text'"
                  v-model="old_password"
                  :rules="[
                    required('Old Password'),
                    minLength('Old Password', 6),
                  ]"
                  label="Old Password"
                ></v-text-field>
                <v-text-field
                  outlined
                  :append-icon="value1 ? 'visibility' : 'visibility_off'"
                  @click:append="() => (value1 = !value1)"
                  :type="value1 ? 'password' : 'text'"
                  v-model="password"
                  :rules="[
                    required('New Password'),
                    minLength('New Password', 6),
                  ]"
                  label="New Password"
                ></v-text-field>
                <v-text-field
                  outlined
                  :append-icon="value2 ? 'visibility' : 'visibility_off'"
                  @click:append="() => (value2 = !value2)"
                  :type="value2 ? 'password' : 'text'"
                  v-model="confirm_password"
                  :rules="[
                    required('Confirm Password'),
                    passwordConfirmationRule,
                    minLength('Confirm Password', 6),
                  ]"
                  label="Confirm Password"
                ></v-text-field>
                <v-col cols="12" class="text-center">
                  <v-btn
                    :loading="loading"
                    dark
                    tile
                    color="#19916B"
                    class="settings-submit"
                    @click="updatePassword"
                  >
                    <v-icon left>vpn_key</v-icon>
                    Update
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
import SettingMenu from "./settingMenu";
export default {
  components: { SettingMenu },
  data() {
    return {
      value: String,
      value1: String,
      value2: String,
      valid: true,
      loading: false,

      message: [],
      old_password: "",
      password: "",
      confirm_password: "",
      required(propertyType) {
        return (v) => (v && v.length > 0) || `You must input a ${propertyType}`;
      },
      minLength(propertyType, length) {
        return (v) =>
          (v && v.length >= length) ||
          `${propertyType} must be at least ${length} characters`;
      },
      maxLength(propertyType, length) {
        return (v) =>
          (v && v.length <= length) ||
          `${propertyType} must be less than ${length} characters`;
      },
    };
  },
  methods: {
    updatePassword() {
      if (this.$refs.form.validate()) {
        this.loading = true;
        axios
          .post(`/change/user/password`, {
            old_password: this.old_password,
            password: this.password,
            password_confirmation: this.confirm_password,
          })
          .then((response) => {
            this.message = response.data;
            this.loading = false;
          })
          .catch((error) => {
            this.loading = false;
          });
      }
    },
  },
  computed: {
    passwordConfirmationRule() {
      return () =>
        this.password === this.confirm_password || "Password must match";
    },
  },
};
</script>
