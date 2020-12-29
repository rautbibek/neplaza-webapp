<template >
  <!-- app bar -->
  <div>
    <v-container class="container">
      <div class="row">
        <div class="top-container">
          <div class="logo">
            <router-link to="/">
              <v-toolbar-title class="text--grey">
                <img src="/image/logo.svg" alt="Bikri Bazzar Logo" />
              </v-toolbar-title>
            </router-link>
          </div>
          <div class="search-bar">
            <search-top></search-top>
          </div>
        </div>
        <div class="buttons-container">
          <span v-if="loggedIn">
            <user-menu></user-menu>
          </span>
          <span v-else>
            <v-btn
              color="#2F3B59"
              class="button mr-3"
              @click="login"
              tile
              dark
              outlined
            >
              <v-icon left>mdi-account-circle</v-icon>
              <span>Login</span>
            </v-btn>
            <v-btn
              color="#2F3B59"
              tile
              dark
              outlined
              @click="signUp"
              class="button"
            >
              <v-icon left>person_add</v-icon>
              <span>Sign Up</span>
            </v-btn>
          </span>
        </div>
      </div>
    </v-container>
  </div>
</template>

<script>
export default {
  data() {
    return {
      //
    };
  },
  methods: {
    login() {
      EventBus.$emit("changeDialog", true);
    },
    signUp() {
      EventBus.$emit("signUp", true);
    },
  },
};
</script>
<style scoped>
.container {
  max-width: unset;
  padding: 20px 40px 20px;
}
.top-container {
  display: flex;
  flex: 1;
  align-items: center;
  justify-content: space-between;
}
.search-bar {
  margin: 0px 12%;
  flex: 1;
}
@media screen and (max-width: 1024px) {
  .search-bar {
    margin: 0px 9%;
  }
}
@media screen and (max-width: 960px) {
  .search-bar {
    margin: 0px 5%;
  }
}
@media screen and (max-width: 860px) {
  .container {
    padding-left: 20px;
    padding-right: 20px;
  }
  .logo img {
    width: 120px;
  }
}
@media screen and (max-width: 700px) {
  .container {
    padding-left: 0px;
    padding-right: 0px;
  }
  .row {
    flex-direction: column;
  }
  .top-container {
    width: 100%;
    padding-bottom: 14px;
    border-bottom: 1px solid #dfdfdf;
  }
  .logo {
    padding-left: 12px;
  }
  .buttons-container {
    padding-top: 14px;
  }
}

@media screen and (max-width: 425px) {
  .search-bar {
    width: 92%;
  }
  .logo {
    margin-bottom: 14px;
  }
  .top-container {
    flex-direction: column;
  }
}
.button {
  border-radius: 2px;
}
.button:hover {
  color: #19916b !important;
}
.button:hover::before {
  opacity: 0;
}
.row {
  margin: 0px;
  padding: 0px;
  align-items: center;
  justify-content: space-between;
}
</style>
