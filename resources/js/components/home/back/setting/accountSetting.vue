<template>
  <div>
    <nav aria-label="breadcrumb ">
      <ol class="breadcrumb">
        <li class="breadcrumb-item pull-right">
          <router-link :to="`/`">Home</router-link>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Settings</li>
        <li class="breadcrumb-item active" aria-current="page">
          Account Settings
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
            <v-card outlined class="pa-8 text-center card">
              <v-btn
                :loading="loading"
                tile
                color="#b65454"
                class="settings-submit mt-auto mb-auto"
                dark
                @click="deactivate"
              >
                <v-icon left>mdi-account-circle</v-icon>
                Deactivate account
              </v-btn>
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
      loading: false,
    };
  },
  methods: {
    deactivate() {
      if (
        confirm(
          "are you sure to want do deactivate your account ? once you deactivate your account you won`t be able to recover yor data."
        )
      ) {
        this.loading = true;
        axios
          .put(`/user/deactivate/account`)
          .then((response) => {
            this.loading = false;
            return this.logout();
          })
          .catch();
      }
    },
    logout() {
      axios.post(`/logout`).then((response) => {
        location.reload();
      });
    },
  },
};
</script>
<style scoped>
.card {
  min-height: 210px;
  display: flex;
  align-items: center;
}
</style>