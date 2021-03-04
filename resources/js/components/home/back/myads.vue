<template>
  <div class="profile-wrapper">
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-row no-gutters class="pb-0">
      <v-col
        v-if="drawer"
        cols="12"
        :md="drawer ? 2 : 0"
        :sm="3"
        class="menu-box-wrapper"
      >
        <div class="menu-box">
          <mymenu></mymenu>
        </div>
      </v-col>
      <v-col
        cols="12"
        :sm="drawer ? 9 : 12"
        :md="drawer ? 10 : 12"
        class="content-wrapper"
      >
        <nav aria-label="breadcrumb ">
          <ol class="breadcrumb">
            <li class="breadcrumb-item pull-right">
              <router-link :to="`/`">Home</router-link>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              My Products
            </li>
          </ol>
        </nav>
        <div class="bottom-sheet-sm">
          <mymenu></mymenu>
        </div>
        <div :class="!drawer && 'collapse-wrapper'" class="pt-2 myads-wrapper">
          <v-icon
            :class="
              drawer ? 'drawer-icon expand-icon' : 'drawer-icon collapse-icon'
            "
            @click.stop="drawer = !drawer"
            >{{ drawer ? "mdi-chevron-left" : "mdi-chevron-right" }}
          </v-icon>
          <v-layout v-if="count > 0" row wrap class="myads-cards-wrapper">
            <v-flex
              xs12
              sm6
              md4
              lg3
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
                <v-card tile class="ma-2 product-card">
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
            <div class="ma-5 mx-auto" v-if="nextUrl">
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
          </v-layout>
          <div v-else class="mt-8 mb-12">
            <empty></empty>
          </div>
        </div>
      </v-col>
    </v-row>
  </div>
</template>
<script>
export default {
  data() {
    return {
      drawer: true,
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

