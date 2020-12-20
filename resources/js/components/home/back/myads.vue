<template>
  <div>
    <nav aria-label="breadcrumb ">
      <ol class="breadcrumb">
        <li class="breadcrumb-item pull-right">
          <router-link :to="`/`">Home</router-link>
        </li>
        <li class="breadcrumb-item active" aria-current="page">My Products</li>
      </ol>
    </nav>
    <div class="py-3">
      <v-overlay :value="overlay">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-overlay>
      <v-container class="profile-wrapper">
        <v-row wrap class="pa-0">
          <v-col cols="12" xs="12" sm="4" md="3" class="menu-box-wrapper">
            <mymenu></mymenu>
          </v-col>
          <v-col cols="12" xs="12" sm="8" md="9">
            <div v-if="count > 0">
              <v-layout row wrap>
                <v-flex
                  xs12
                  sm6
                  md4
                  lg4
                  xl2
                  v-for="(ads, index) in my_ads"
                  :key="index"
                >
                  <v-lazy
                    v-model="isActive"
                    :options="{
                      threshold: 0.5,
                    }"
                    min-height="200"
                    transition="fade-transition"
                  >
                    <v-card tile class="ma-3 product-card">
                      <!-- image part -->
                      <router-link :to="`/ad/detail/${ads.id}/${ads.slug}`">
                        <cover :ads="ads"></cover>

                        <!-- title and subtitle part -->
                        <card-title :ads="ads"></card-title>
                      </router-link>
                      <card-menu :ads="ads"></card-menu>
                    </v-card>
                  </v-lazy>
                </v-flex>
              </v-layout>
              <div class="text-center mt-5" v-if="nextUrl">
                <v-btn
                  :loading="loading"
                  dark
                  color="#2F3B59"
                  class=""
                  @click.prevent="fetch(nextUrl)"
                >
                  Load More
                  <template v-slot:loader>
                    <span>Loading...</span>
                  </template>
                  <v-icon right>cached</v-icon>
                </v-btn>
              </div>
            </div>
            <div v-else>
              <empty></empty>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      overlay: true,
      isActive: false,
      loading: false,
      my_ads: [],
      nextUrl: null,
      count: 1,
    };
  },
  methods: {
    fetch(url) {
      this.overlay = true;
      if (!this.loggedIn) {
        EventBus.$emit("changeDialog", true);
        this.$router.push("/");
        return;
      }
      this.loading = true;
      axios.get(url).then(({ data }) => {
        this.my_ads.push(...data.data);
        this.count = this.my_ads.length;
        this.nextUrl = data.next_page_url;
        this.loading = false;
        this.overlay = false;
      });
    },
  },
  created() {
    EventBus.$on("deleteAd", (data) => {
      this.my_ads.splice(this.my_ads.indexOf(data), 1);
    });
    EventBus.$on("soldAd", (data) => {
      this.my_ads.splice(this.my_ads.indexOf(data), 1);
    });
    this.fetch(`/user/product/myads`);
  },
};
</script>
