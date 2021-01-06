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
              Deleted Products
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
              <v-card class="ma-3 product-card">
                <v-menu>
                  <template v-slot:activator="{ on: menu, attrs }">
                    <v-tooltip bottom>
                      <template v-slot:activator="{ on: tooltip }">
                        <v-btn
                          class="menu-settings-btn"
                          absolute
                          x-small
                          fab
                          v-bind="attrs"
                          v-on="{ ...tooltip, ...menu }"
                        >
                          <v-icon>mdi-cog</v-icon>
                        </v-btn>
                      </template>
                      <span>Settings</span>
                    </v-tooltip>
                  </template>
                  <v-list dense>
                    <v-list-item-group>
                      <v-list-item @click="permanentDelete(ads)">
                        <v-list-item-icon>
                          <v-icon small>delete_forever</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                          <v-list-item-title
                            >Delete Permanently</v-list-item-title
                          >
                        </v-list-item-content>
                      </v-list-item>

                      <v-list-item route @click="restore(ads)">
                        <v-list-item-icon>
                          <v-icon small>restore</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                          <v-list-item-title>Restore</v-list-item-title>
                        </v-list-item-content>
                      </v-list-item>
                    </v-list-item-group>
                  </v-list>
                </v-menu>
                <!-- image part -->
                <cover :ads="ads"></cover>

                <!-- title and subtitle part -->
                <card-title :ads="ads"></card-title>
              </v-card>
            </v-flex>
          </v-layout>
          <div v-else class="mt-8 mb-12">
            <empty title="No Deleted Products" noButton="true"></empty>
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
      overlay: false,
      drawer: true,
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
    restore(item) {
      this.overlay = true;
      axios
        .put(`/restore/ad/${item.id}`)
        .then((response) => {
          this.$toast.success(response.data, "success", {
            timeout: 3000,
            position: "topRight",
          });
          this.my_ads.splice(this.my_ads.indexOf(item), 1);
          this.count--;
          this.overlay = false;
        })
        .catch();
    },

    permanentDelete(ads) {
      if (confirm("are you sure to want to delete this ad")) {
        this.overlay = true;
        axios
          .delete(`/product/permanent/delete/${ads.id}`)
          .then((response) => {
            this.$toast.success(response.data, "success", {
              timeout: 3000,
              position: "topRight",
            });
            this.my_ads.splice(this.my_ads.indexOf(ads), 1);
            this.count--;
            this.overlay = false;
          })
          .catch((error) => {
            this.$toast.error(error.response.data.message, "unauthorized", {
              timeout: 3000,
              position: "topRight",
            });
            this.overlay = false;
          });
      }
    },
  },
  created() {
    this.fetch(`/user/product/deleted`);
  },
};
</script>
<style scoped>
.v-list-item__icon {
  margin-right: 0px !important;
}
.v-list a:hover {
  color: #19916b !important;
}
.v-list {
  min-width: 150px;
}
</style>