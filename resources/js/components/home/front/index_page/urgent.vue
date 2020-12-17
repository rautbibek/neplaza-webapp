<template>
  <div v-if="count > 0" class="urgent-container">
    <v-container class="py-0">
      <p class="featured-title text-center">
        Urgent Products
        <!-- <v-btn
          color="#0c1963"
          dark
          tile
          small
          router
          :to="`/urgent/sell`"
          v-if="count > 3"
        >
          view all
          <v-icon right>keyboard_arrow_right</v-icon>
        </v-btn> -->
      </p>
    </v-container>
    <v-container class="pb-14">
      <v-layout row wrap class="px-4">
        <v-overlay :value="overlay">
          <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
        <v-flex
          xs12
          sm6
          md4
          lg3
          xl2
          v-for="(ads, index) in all_ads"
          :key="index"
        >
          <card-lazy :ads="ads"></card-lazy>
        </v-flex>
      </v-layout>
    </v-container>
  </div>
</template>
<script>
export default {
  data() {
    return {
      all_ads: [],
      overlay: false,
      count: 0,
    };
  },
  methods: {
    favorite() {
      this.color = "red";
      this.background = "white";
    },
    getAds() {
      this.overlay = true;
      axios.get(`/urgent/ad`).then((response) => {
        this.all_ads = response.data;
        this.count = this.all_ads.length;
        this.overlay = false;
      });
    },
  },

  created() {
    this.getAds();
  },
};
</script>
<style scoped>
.urgent-container {
  background: #f3f2ed;
}
.container {
  padding: 0px;
}
</style>