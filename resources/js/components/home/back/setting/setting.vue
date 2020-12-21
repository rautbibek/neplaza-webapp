<template>
  <div>
    <nav aria-label="breadcrumb ">
      <ol class="breadcrumb">
        <li class="breadcrumb-item pull-right">
          <router-link :to="`/`">Home</router-link>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Settings</li>
      </ol>
    </nav>
    <div class="py-5">
      <v-overlay :value="overlay">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-overlay>
      <v-container class="container-wrapper">
        <v-row wrap>
          <v-col cols="12" xs="12" sm="4" md="3" class="menu-box-wrapper pt-0">
            <settingMenu></settingMenu>
          </v-col>
          <v-col cols="12" xs="12" sm="8" md="9">
            <v-card outlined class="pa-8 card">
              <v-row no-gutters>
                <v-col lg="9" sm="9">
                  <p class="settings-title">Contact Visibility</p>
                  <span class="settings-subtitle">
                    Choose whether to hide or show your phone number
                  </span>
                </v-col>
                <v-col lg="3" sm="3">
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
              <v-row no-gutters>
                <v-col lg="9" sm="9">
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
                <v-col lg="3" sm="3" class="d-flex phone-container">
                  <p class="phone">
                    {{ my_data.contact_number || "-" }}
                  </p>
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
                </v-col>
              </v-row>
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
      my_data: {},
      user_id: this.loginUser.id,
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