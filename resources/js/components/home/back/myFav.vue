<template>
  <div>
    <nav aria-label="breadcrumb ">
      <ol class="breadcrumb">
        <li class="breadcrumb-item pull-right">
          <router-link :to="`/`">Home</router-link>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          Favorite Products
        </li>
      </ol>
    </nav>
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <div class="py-5">
      <v-container>
        <div v-if="fav_ads.length > 0">
          <v-layout row wrap class="px-4">
            <v-flex
              xs12
              sm6
              md4
              lg3
              xl2
              v-for="(ads, index) in fav_ads"
              :key="index"
            >
              <v-card tile class="ma-3 product-card">
                <v-btn
                  @click="remove(ads.id,index)"
                  class="favourite"
                  color="white"
                  absolute
                  x-small
                  dark
                  fab
                  right
                  
                >
                  <v-icon color="red">mdi-heart</v-icon>
                  
                </v-btn>

                <router-link :to="`/ad/detail/${ads.id}/${ads.slug}`">
                  <!-- image part -->
                  <cover :ads="ads"></cover>

                  <!-- title and subtitle part -->
                  <card-title :ads="ads"></card-title>
                </router-link>
              </v-card>
            </v-flex>
          </v-layout>
        </div>
        <div class="text-center m-5 p-3" v-else>
          <empty title="No Favourite Products" noButton="true"></empty>
        </div>
      </v-container>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      overlay: false,
      fav_ads: [],
      count: 1,
    };
  },
  methods: {
    fetch() {
      this.overlay = true;
      if (!this.loggedIn) {
        this.$router.push("/");
        EventBus.$emit("changeDialog", true);
        return;
      }
      axios.get(`/user/favorite/product`).then((response) => {
        this.overlay = false;
        this.fav_ads = response.data[0].favourit_products;
        this.count = this.fav_ads.length;
      });
    },

    remove(id,index) {
      this.fav = false;
      axios
        .post(`/favorite/${id}/add`)
        .then((response) => {
          this.fav_ads.splice(index, 1);
        })
        .catch();
    },
  },
  created() {
    this.fetch();
  },
};
</script>
<style scoped>
.favourite {
  right: 8px;
  bottom: 8px;
}
.favourite-icon i {
  font-size: 24px !important;
}
</style>