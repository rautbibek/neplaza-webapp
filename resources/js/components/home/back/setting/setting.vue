<template>
  <div>
      <v-overlay :value="overlay">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-overlay>
      <div>
        <v-row no-gutters>
          <v-col v-if="drawer"
            cols="12"
            :md="drawer ? 2 : 0"
            :sm="3">
            <div class="menu-box">
            <settingMenu></settingMenu>
            </div>
          </v-col>
          <v-col cols="12"
            :sm="drawer ? 9 : 12"
            :md="drawer ? 10 : 12"
        class="content-wrapper">
            
              <nav aria-label="breadcrumb ">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item pull-right">
                    <router-link :to="`/`">Home</router-link>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">Settings</li>
                </ol>
              </nav>
            
            
              <div class="pa-8 col-md-8">
              <h4 class="settings-form-title">Contact Setting</h4>
                <v-row>
                <v-col cols="12" lg="6" md="6" sm="6" xs="12">
                  <p class="settings-title">Contact Visibility</p>
                  <span class="settings-subtitle">
                    Choose whether to hide or show your phone number
                  </span>
                </v-col>
                <v-col cols="12" lg="6" md="6" sm="6" xs="12">
                  <v-switch
                    color="#19916B"
                    v-model="contact_status"
                    :label="label"
                    class="switch"
                    @change="change_contact_status"
                    >Hidden for all
                  </v-switch>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" lg="6" md="6" sm="6" xs="12">
                  <h5 class="settings-title">
                    Contact Number
                    <v-tooltip bottom>
                      <template v-slot:activator="{ on, attrs }">
                        <v-icon
                          v-bind="attrs"
                          :color="
                            my_data.phone_verified ? '#00a2f0' : '#b65454'
                          "
                          class="ml-2"
                          small
                          v-on="on"
                          >{{
                            my_data.phone_verified
                              ? "mdi-check-decagram"
                              : "error"
                          }}
                        </v-icon>
                      </template>
                      <span>
                        {{
                          my_data.phone_verified
                            ? "Verified Phone Number"
                            : "Phone Number not Verified"
                        }}</span
                      >
                    </v-tooltip>
                  </h5>
                  <span class="settings-subtitle">
                    Your phone number is
                    {{ my_data.phone_verified ? "" : "not " }}verified
                  </span>
                </v-col>
                <v-col cols="12" lg="6" md="6" sm="6" xs="12" class=" phone-container">
                  <p class="phone">
                    {{ my_data.contact_number || "-" }}
                    <v-btn
                    class="change"
                    small
                    color="#19916B"
                    text
                    @click="contact_form"
                  >
                    <v-icon small color="#19916B">
                      {{ my_data.contact_number ? "edit" : "add" }}
                    </v-icon>
                    {{ my_data.contact_number ? "Edit" : "Add" }}
                  </v-btn>
                  </p>  
                </v-col>
              </v-row>
              </div>
            
          </v-col>
        </v-row>
      </div>
  </div>
</template>
<script>
import SettingMenu from "./settingMenu";
export default {
  components: { SettingMenu },
  data() {
    return {
      drawer:true,
      my_data: {},
      user_id: null,
      contact_status: true,
      overlay: false,
    };
  },
  methods: {
    contact_form() {
      EventBus.$emit("profileForm", true);
    },
    userData() {
      this.overlay = true;
      axios
        .get(`/get/login/user`)
        .then((response) => {
          this.my_data = response.data;
          this.contact_status = this.my_data.hide_contact;
          this.overlay = false;
        })
        .catch();
    },
    change_contact_status() {
      this.overlay = true;
      axios
        .put(`/user/contact/status`, {
          status: this.contact_status,
        })
        .then((response) => {
          this.overlay = false;
          this.userData();
        })
        .catch();
    },
  },
  computed: {
    label() {
      return this.contact_status ? "Hidden for all " : "Visible for all";
    },
  },
  created() {
    
    EventBus.$on("contactUpdated", (data) => {
      this.userData();
    });
    this.userData();
  },
};
</script>
<style scoped>
.settings-title {
  color: #2f3b59;
  font-size: 16px;
  margin-bottom: 0px;
}
.settings-subtitle {
  color: #00000099;
}
.phone {
  font-size: 14px;
  margin-bottom: 0px;
  color: #00000099;
}
.phone-container {
  flex-wrap: wrap;
}
.change {
  text-transform: none;
  font-weight: bold;
  font-size: 14px;
}
.d-flex {
  align-items: center;
}
.card {
  min-height: 210px;
}

@media screen and (max-width: 600px) {
  .row {
    flex-direction: column;
  }
}
</style>