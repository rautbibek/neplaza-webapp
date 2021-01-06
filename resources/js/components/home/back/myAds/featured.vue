<template>
  <div class="profile-wrapper">
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-row no-gutters class="pa-0">
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
            <li class="breadcrumb-item pull-right">
              <router-link :to="`/user/myads`">My Products</router-link>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              Featured Products
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
              <v-card tile class="ma-3">
                <!-- image part -->
                <router-link :to="`/ad/detail/${ads.id}/${ads.slug}`">
                  <cover :ads="ads"></cover>

                  <div v-if="ads.featured">
                    <v-chip
                      class="expiry-date-chip"
                      small
                      label
                      :color="
                        ads.featured.remaining_days < 3 ? 'red' : 'indigo'
                      "
                      outlined
                    >
                      Expire After :
                      {{ ads.featured.remaining_days }} Days
                    </v-chip>
                  </div>
                  <!-- title and subtitle part -->
                  <card-title :ads="ads"></card-title>
                </router-link>
                <card-menu :ads="ads"></card-menu>
              </v-card>
            </v-flex>
          </v-layout>
          <div v-else class="mt-8 mb-12">
            <empty title="No Featured Products"></empty>
          </div>
        </div>
      </v-col>
    </v-row>

    <div class="text-center mt-5" v-if="nextUrl">
      <v-btn
        :loading="loading"
        outlined
        tile
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
</template>
<script>
export default {
  data() {
    return {
      loading: false,
      drawer: true,
      my_ads: [],
      overlay: false,
      nextUrl: null,
      count: 1,
    };
  },
  methods: {
    fetch(url) {
      this.overlay = true;
      if (!this.loggedIn) {
        this.$router.push("/");
        EventBus.$emit("changeDialog", true);
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
    this.fetch(`/user/product/featured`);
  },
};
</script>