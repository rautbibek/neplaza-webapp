<template>
  <div  v-if="count > 0">
    <v-container class="py-0">
      <p class="featured-title text-center">Featured Products</p>
    </v-container>
    <div class="container mb-14">
      <v-container>
        <v-slide-group
            v-model="model"
            center-active
            show-arrows
    >
          <v-slide-item
            v-for="(feature, index) in featured"
            :key="index"
            
           
          >
            <v-card class="card product-card ma-2" width="250">
              <!-- <favorite
                :is_favorite="feature.favorite_to_users.length ? true : false"
                :product_id="feature.id"
              ></favorite> -->
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
      <v-container class="button-container">
        <v-btn
          color="#0c1963"
          dark
          tile
          class="mt-10"
          router
          :to="`/feature/ads`"
          v-if="count > 6"
        >
          view all
          <v-icon right>keyboard_arrow_right</v-icon>
        </v-btn>
      </v-container>
    </div>
  </div>
</template>

<script>
import { Carousel, Slide } from "vue-carousel";

export default {
  components: {
    sliders: Carousel,
    Slide,
  },
  data() {
    return {
      featured: [],
      count: 0,
    };
  },
  methods: {
    getFeatured() {
      axios.get(`/front/featured/product`).then((response) => {
        this.featured = response.data;
        this.count = this.featured.length;
      });
    },
  },
  created() {
    return this.getFeatured();
  },
};
</script>

<style scoped>
.button-container {
  display: flex;
  justify-content: center;
}
.container {
  padding: 0px;
}

.card-date {
  height: 40px;
  border-bottom: 1px solid #f2f2f2;
}
.featured-card {
  padding: 0px 12px;
}
</style>

