<template>
  <div class="profile-wrapper">
    <v-row no-gutters class="pa-0">
      <v-col
        v-if="drawer"
        cols="12"
        :md="drawer ? 2 : 0"
        :sm="3"
        class="menu-box-wrapper"
      >
        <div class="menu-box">
          <settingMenu></settingMenu>
        </div>
      </v-col>
      <v-col
        cols="12"
        :sm="drawer ? 9 : 12"
        :md="drawer ? 10 : 12"
        class="content-wrapper"
      >
        <nav aria-label="breadcrumb ">
          <ol class="breadcrumb">
            <li class="breadcrumb-item pull-right">
              <router-link :to="`/`">Home</router-link>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              Account Settings
            </li>
          </ol>
        </nav>
        <div class="bottom-sheet-sm">
          <settingMenu></settingMenu>
        </div>
        <div :class="!drawer && 'collapse-wrapper'">
          <v-icon
            :class="
              drawer ? 'drawer-icon expand-icon' : 'drawer-icon collapse-icon'
            "
            @click.stop="drawer = !drawer"
            >{{ drawer ? "mdi-chevron-left" : "mdi-chevron-right" }}
          </v-icon>
          <v-card
            outlined
            :class="drawer ? 'my-7' : 'my-5'"
            class="mx-10 pa-8 card"
          >
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
        </div>
      </v-col>
    </v-row>
  </div>
</template>
<script>
import SettingMenu from "./settingMenu";
export default {
  components: { SettingMenu },
  data() {
    return {
      loading: false,
      drawer: true,
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
.collapse-wrapper {
  min-height: 355px;
  padding-top: 10px;
}
@media screen and (max-width: 425px) {
  .card {
    margin: 30px 20px !important;
  }
}
</style>