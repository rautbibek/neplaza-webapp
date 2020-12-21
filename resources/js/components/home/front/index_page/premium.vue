<template>
  <div v-if="count > 0">
    <v-container class="py-0">
      <p class="featured-title text-center">Featured Products</p>
    </v-container>
    <div class="container mb-14">
      <v-container>
        <sliders
          style="margin: 0px; padding: 0px"
          :autoplay="true"
          :autoplayHoverPause="true"
          :scrollPerPage="false"
          :loop="true"
          :spacePadding="1"
          :navigationEnabled="true"
          :paginationEnabled="true"
          :responsive="true"
          :perPageCustom="[
            [300, 1],
            [500, 2],
            [600, 4],
          ]"
          class="row"
        >
          <slide
            v-for="(feature, index) in featured"
            :key="index"
            class="col-md-3 col-sm-6 featured-card"
            router
            :to="`/`"
          >
            <v-card class="card product-card">
              <favorite
                :is_favorite="feature.favorite_to_users.length ? true : false"
                :product_id="feature.id"
              ></favorite>
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
          </slide>
        </sliders>
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

