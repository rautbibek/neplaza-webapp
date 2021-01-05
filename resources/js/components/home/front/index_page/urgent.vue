<template>
  <div v-if="count > 0" class="urgent-container">
    <v-container >
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
          <v-slide-group
            v-model="model"
            center-active
            show-arrows
    >
      <v-slide-item
        v-for="(feature, index) in all_ads"
        :key="index"
         >
        <v-card class="card product-card ma-2" width="250"
          >
              <!-- <favorite
                :is_favorite="feature.favorite_to_users.length ? true : false"
                :product_id="feature.id"
              ></favorite>  -->
              <!-- image part -->
              <router-link :to="`/ad/detail/${feature.id}/${feature.slug}`">
                <v-img
                  class="white--text align-end"
                  height="190px"
                  :src="feature.product_cover"
                >
                </v-img>
                <card-title :ads="feature"></card-title>
              </router-link>
        </v-card>
      </v-slide-item>
    </v-slide-group>
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
      model: null,
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