<template>
  <div>
    <v-container >
      <p class="featured-title">Recent Listing</p>
    </v-container>
    <div class="pb-5">
      <div class="container">
        <v-layout row wrap class="px-1">
          <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
          </v-overlay>
          <v-flex
            xs6
            sm6
            md3
            lg3
            xl2
            v-for="(ads, index) in all_ads"
            :key="index"
          >
            <card-lazy :ads="ads"></card-lazy>
          </v-flex>
        </v-layout>
        <!-- <update-profile></update-profile> -->
        <div class="text-center ma-5" v-if="nextUrl">
            <v-btn :loading="loading" outlined  color="#2F3B59" @click.prevent="more(nextUrl)">

                Load More
                <template v-slot:loader>
                    <span>Loading...</span>
                </template>
                <v-icon right>cached</v-icon>
            </v-btn>
            </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      all_ads: [],
      overlay: false,
      isActive: false,
      loading:false,
      nextUrl : null,
    };
  },
  methods: {
    fetch(url){
          this.overlay= true
          this.loading=true;
          axios.get(url)
               .then(({data}) =>{
                     this.all_ads.push(...data.data);
                     this.nextUrl = data.next_page_url
                     this.loading = false;
                     this.overlay = false;
                 })
      },
      more(nextUrl){
        this.loading=true;
        axios.get(nextUrl)
             .then(({data}) =>{
                this.all_ads.push(...data.data);
                this.nextUrl = data.next_page_url
                this.loading = false;
            })
      },
    favorite() {
      this.color = "red";
      this.background = "white";
    },
    getAds() {
      this.overlay = true;
      this.fetch(`/front/home/product`);
    },
  },

  created() {
    this.getAds();
  },
};
</script>
