<template>
  <div>
    <div >
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
                <li class="breadcrumb-item active" aria-current="page">
                  Account Settings
                </li>
              </ol>
            </nav>
            <div outlined class="pa-8 mt-5 text-center">
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