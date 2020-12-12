<template>
  <v-card v-if="count > 0" outlined tile flat>
    <v-container class="py-0">
      <p class="featured-title text-center">
        Featured Products
        <!-- <v-btn color="#0c1963" small dark tile router :to="`/feature/ads`" v-if="count>6"  >
          view all
          <v-icon right>keyboard_arrow_right</v-icon>
        </v-btn> -->
      </p>
    </v-container>
    <div class="container">
      <v-container>
        <sliders
          style="margin: 0px; padding: 0px"
          :autoplay="true"
          :autoplayHoverPause="true"
          :scrollPerPage="false"
          :loop="true"
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
            <v-card class="card">
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
    </div>
  </v-card>
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
.featured-title {
  margin-bottom: 0px;
  padding: 40px 0px 20px;
  font-size: 25px;
  font-weight: 600;
  letter-spacing: 1px;
}
.container {
  padding: 12px 0px;
}
.card {
  box-shadow: 0px 0px 16px rgba(0, 0, 0, 0.04);
  border: 1px solid #eee;
  padding-bottom: 10px;
}
.card-date {
  height: 40px;
  border-bottom: 1px solid #f2f2f2;
}
.featured-card {
  padding: 0px 12px;
}
.favourite {
  opacity: 0;
  height: 10px;
  transition: height 0.2s ease;
}
.favourite > i {
  font-size: 0px;
}
.card:hover .favourite {
  opacity: 1;
  height: 32px;
}
.card:hover .favourite > i {
  font-size: 18px;
}
</style>

