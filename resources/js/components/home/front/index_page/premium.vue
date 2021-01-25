<template>
  <div  v-if="count > 0">
    
    <div class="container mb-4">
      <v-container>
        <p class="featured-title text-center">Featured Products</p>
        <div class="px-2">
            <vue-horizontal :button-between="false">
            <section v-for="(ads,index) in featured" :key="index" style="margin:5px; padding:0xp">
             <v-card class="card product-card" >
             
              <router-link :to="`/ad/detail/${ads.id}/${ads.slug}`">
                <v-img
                  class="white--text align-end"
                  aspect-ratio="1.4"
                  max-height="190px"
                  gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.3)"
                  :src="ads.product_cover"
                >
                </v-img>
                <div class="feature-top-left">Featured</div>
                <card-title style="border-left:2px solid yellow" :ads="ads"></card-title>
              </router-link>
            </v-card>
              
            </section>
            <section v-if="count > 7">
                <v-col  class="text-center " style=" margin-top:100px">
                  <router-link :to="`/feature/ads`">
                  <v-card-title >Veiw all<v-btn
                    class="mx-2"
                    fab
                    light
                    small
                  >
                    <v-icon light>
                      keyboard_arrow_right
                    </v-icon>
                  </v-btn></v-card-title>
                  </router-link>
                </v-col>
            </section>
          </vue-horizontal>
          </div>
      </v-container>
      
    </div>
  </div>
</template>

<script>
import VueHorizontal from "vue-horizontal";
export default {
  components: {VueHorizontal},
  data() {
    return {
      featured: [],
      count: 0,
      model:null,
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
.feature-top-left {
  position: absolute;
  color: white;
  padding:2px 10px 2px 10px;
  background:#bfaf1efa;
  border-radius:3px;
  top: 8px;
  left: 16px;
}
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
section >div {
  padding: 0px 0px;
  width: 100%;
  margin-right: 5px;
}
.v-hl-responsive{
  margin:5px;
}
@media (min-width: 300px) {
  section {
    width: calc((100% - (24px)) / 1);
  }
}
@media (min-width: 360px) {
  section {
    width: calc((100% - (24px)) / 2);
  }
}
@media (min-width: 640px) {
  section {
    width: calc((100% - (24px)) / 2);
  }
}

@media (min-width: 768px) {
  section {
    width: calc((100% - (2 * 24px)) / 3);
  }
}

@media (min-width: 1024px) {
  section {
    width: calc((100% - (3 * 24px)) / 4);
  }
}
</style>

