<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="380">
      <v-card>
        <v-card-title class="text-right">
          Login with
          <v-spacer></v-spacer>
          <v-btn x-small text @click="dialog = false">
            <v-icon small>close</v-icon>
          </v-btn>
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text class="flex">
          <v-btn fab href="/login/facebook" color="#3b5998">
            <v-icon color="white">mdi-facebook</v-icon>
          </v-btn>
          <v-btn href="/login/google" fab color="#db4a39">
            <v-icon color="white">mdi-google-plus</v-icon>
          </v-btn>
          <v-btn fab href="/login/twitter" color="#00acee">
            <v-icon color="white">mdi-twitter</v-icon>
          </v-btn>
        </v-card-text>
        <v-card-text>
          <div class="separator">OR</div>
          <v-btn dark href="/login" large color="#2f3b59" class="my-4" style="width:100%">
            <v-icon>mdi-account-circle</v-icon>&nbsp; Username / Password
          </v-btn>

          <!-- <v-btn href="/login/yahoo"  large dark color="#6001d2" class="my-1" style="width:100%">
            <v-icon>mdi-email</v-icon>
             &nbsp; Email
          </v-btn>-->
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
export default {
  data() {
    return {
      dialog: false
    };
  },
  created() {
    EventBus.$on("changeDialog", data => {
      this.dialog = data;
    });
  }
};
</script>
<style scoped>
.v-card__title {
  padding-bottom: 0px !important;
}
.flex {
  display: flex;
  justify-content: space-evenly;
}
.v-btn__content {
  font-size: 20px;
}
.v-btn {
  padding: 0px !important;
}
</style>

