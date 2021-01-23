<template>
  <div v-if="count > 0" class="urgent-container">
    <v-container class="pb-1" >
        <p class="featured-title text-center">
          Urgent Products
        </p>
          <div class="px-2 mb-4">
            <vue-horizontal :button-between="false">
            <section v-for="(ads,index) in all_ads" :key="index" style="margin:5px; padding:0xp">
             <v-card class="card product-card " >
             
              <router-link :to="`/ad/detail/${ads.id}/${ads.slug}`">
                <v-img
                  class="white--text align-end"
                  gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.3)"
                  aspect-ratio="1.4"
                  max-height="190px"
                  :src="ads.product_cover"
                >
                </v-img>
                <card-title :ads="ads"></card-title>
              </router-link>
            </v-card>
              
            </section>
            <section v-if="count > 7">
                <v-col  class="text-center " style=" margin-top:170px">
                  <router-link :to="`/urgent/sell`">
                  <v-card-title>Veiw all<v-btn
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
</template>
<script>
import VueHorizontal from "vue-horizontal";
export default {
  components: {VueHorizontal},
  data() {
    return {
      all_ads: [],
      overlay: false,
      count: 0,
      model: null,
        autoplay: { play: true, repeat: true, speed: 2500 },
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