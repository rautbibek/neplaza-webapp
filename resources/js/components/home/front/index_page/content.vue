<template>
  <v-card tile flat >
    <v-container >
      <p class="featured-title text-center">Recent Listing</p>
    </v-container>
    <div>
      <v-container>
        <v-layout row wrap >
          <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
          </v-overlay>
          <v-flex
            xs6
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
        <update-profile></update-profile>
        <p class="text-center mt-5">
          <v-btn class="mt-3" color="#0c1963" small router :to="`/ads`" dark>
            view all
            <v-icon right>keyboard_arrow_right</v-icon>
          </v-btn>
        </p>
      </v-container>
    </div>
  </v-card>
</template>
<script>
export default {
  data() {
    return {
      all_ads: [],
      overlay: false,
    };
  },
  methods: {
    favorite() {
      this.color = "red";
      this.background = "white";
    },
    getAds() {
      this.overlay = true;
      axios.get(`/front/home/product`).then((response) => {
        this.all_ads = response.data;
        this.overlay = false;
      });
    },
  },

  created() {
    this.getAds();
  },
};
</script>
