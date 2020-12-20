<template>
  <div>
    <nav aria-label="breadcrumb ">
      <ol class="breadcrumb">
        <li class="breadcrumb-item pull-right">
          <router-link :to="`/`">Home</router-link>
        </li>
        <li class="breadcrumb-item pull-right">
          <router-link :to="`/user/myads`">My Products</router-link>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          Urgent Products
        </li>
      </ol>
    </nav>
    <div class="py-3">
      <v-overlay :value="overlay">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-overlay>
      <v-container>
        <v-row wrap class="px-4">
          <v-col cols="12" xs="12" sm="4" md="3" class="menu-box-wrapper">
            <mymenu></mymenu
          ></v-col>
          <v-col cols="12" xs="12" sm="8" md="9">
            <div v-if="count < 0">
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
                  <v-card tile class="ma-3 product-card">
                    <card-menu :ads="ads"></card-menu>
                    <!-- image part -->
                    <router-link :to="`/ad/detail/${ads.id}/${ads.slug}`">
                      <cover :ads="ads"></cover>
                      <div v-if="ads.urgent">
                        <v-chip
                          class="expiry-date-chip"
                          small
                          outlined
                          label
                          :color="
                            ads.urgent.remaining_days < 3 ? 'red' : 'indigo'
                          "
                        >
                          Expire After : {{ ads.urgent.remaining_days }} Days
                        </v-chip>
                      </div>
                      <!-- title and subtitle part -->
                      <card-title :ads="ads"></card-title>
                    </router-link>
                  </v-card>
                </v-flex>
              </v-layout>
            </div>
            <div v-else class="mt-3">
              <empty noButton="true"></empty>
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
      </v-container>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      loading: false,
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
    this.fetch(`/user/product/urgent`);
  },
};
</script>
