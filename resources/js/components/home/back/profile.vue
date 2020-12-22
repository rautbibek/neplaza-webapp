<template>
  <div>
    <nav aria-label="breadcrumb ">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item pull-right">
          <router-link :to="`/`">Home</router-link>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Profile</li>
      </ol>
    </nav>
    <div>
      <v-overlay :value="overlay">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-overlay>
      <v-img src="/image/default_cover.png" height="250"></v-img>
      <v-container class="container pa-0 mb-10">
        <v-card class="pa-15 card">
          <profile-form :userData="profile"></profile-form>
          <div v-if="checkCompletion">
            <ProfileCompletion></ProfileCompletion>
          </div>
        </v-card>
      </v-container>
    </div>
  </div>
</template>
<script>
import ProfileCompletion from "./profile/complete_profile";
export default {
  components: {
    ProfileCompletion,
  },
  data() {
    return {
      url: "",
      dialog: false,
      valid: true,
      image: [],
      show: true,
      profile: {},
      overlay: false,
      select(propertyType) {
        return (value) =>
          !value ||
          value.size < 5000000 ||
          `${propertyType} size should be less than 2 MB!`;
      },
    };
  },
  methods: {
    userProfile() {
      this.overlay = true;
      axios
        .get(`/get/login/user/`)
        .then((response) => {
          this.profile = response.data;
          this.overlay = false;
        })
        .catch();
    },
  },
  computed: {
    checkCompletion() {
      return !this.profile.completion;
    },
  },
  created() {
    if (!this.loggedIn) {
      this.$router.push("/");
      EventBus.$emit("changeDialog", true);
      return;
    }
    return this.userProfile();
  },
  mounted() {
    EventBus.$on("updateUser", (data) => {
      return this.userProfile();
    });
  },
};
</script>
<style scoped>
.container {
  margin-top: -100px;
  max-width: 75% !important;
}
@media screen and (max-width: 768px) {
  .card {
    padding: 40px 25px !important;
  }
  .container {
    max-width: 85% !important;
  }
}
</style>
