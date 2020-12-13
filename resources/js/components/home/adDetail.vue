<template>
  <div>
    <div v-if="count > 0">
      <nav aria-label="breadcrumb ">
        <ol class="breadcrumb">
          <li class="breadcrumb-item pull-right">
            <router-link :to="`/`">Home</router-link>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            <router-link :to="`/category/${category.slug}`">{{
              category.name
            }}</router-link>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            <router-link :to="`/category/${category.id}/${scategory.slug}`">{{
              scategory.name
            }}</router-link>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            {{ productId }}
          </li>
        </ol>
      </nav>

      <v-overlay :value="overlay" absolute>
        <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-overlay>
      <div>
        <div v-for="(ad, index) in detail" :key="index">
          <v-container>
            <v-row>
              <v-col
                cols="12"
                lg="5"
                md="5"
                sm="12"
                xs="12"
                class="image-container"
              >
                <ad-image :images="ad.product_image"></ad-image>
              </v-col>

              <v-col cols="12" lg="7" md="7" class="title-container">
                <ad-user :ad="ad" :owner="ad.user"></ad-user>
              </v-col>
            </v-row>
            <v-row>
              <v-col
                cols="12"
                lg="12"
                md="12"
                sm="12"
                xs="12"
                class="title-container"
              >
                <ad-description :ad="ad"></ad-description>
              </v-col>
            </v-row>
            <v-row>
              <v-col>
                <ad-comment></ad-comment>
              </v-col>
            </v-row>
          </v-container>
        </div>
      </div>
    </div>
    <div v-else>
      <div>
        <nav aria-label="breadcrumb ">
          <ol class="breadcrumb">
            <li class="breadcrumb-item pull-right">
              <router-link :to="`/`">Home</router-link>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              404 page not found
            </li>
          </ol>
        </nav>
        <v-container>
          <div class="container">
            <v-card dense tile flat max-width="344" class="mx-auto">
              <h4 class="text-center" style="font-size: 50px; color: indigo">
                Oops !
              </h4>
              <p class="text-center mt-3" style="font-size: 20px">
                We can't seem to find the ad your are looking for.
              </p>
              <!-- <v-img
                            src="/storage/404.png"
                            height="194"
                        ></v-img> -->

              <div class="text-center">
                <v-btn router to="/" dark tile color="deep-purple accent-4">
                  Back to homepage
                </v-btn>
              </div>
            </v-card>
          </div>
        </v-container>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      overlay: false,
      count: "1",
      detail: [],
      images: {},
      owner: {},
      category: {},
      scategory: {},
      productId: "",
      fav_count: null,
    };
  },
  methods: {
    getAd() {
      this.overlay = true;
      axios
        .get(
          `/product/detail/${this.$route.params.id}/${this.$route.params.slug}`
        )
        .then((response) => {
          this.detail = response.data;
          this.count = this.detail.length;
          this.category = response.data[0].category;
          this.scategory = response.data[0].scategory;
          this.productId = response.data[0].productid;
          this.overlay = false;
        });
    },
  },
  created() {
    //console.log(window.location.pathname);
    //localStorage.url = window.location.pathname;
    this.getAd();
  },
  watch: {
    $route(to, from) {
      return this.getAd();
    },
  },
};
</script>
<style scoped>
@media screen and (max-width: 575px) {
  .breadcrumb {
    padding-left: 16px;
    padding-right: 16px;
    margin-bottom: 0px;
  }
  .title-container {
    padding-left: 16px;
    padding-right: 16px;
  }
  .breadcrumb > li {
    font-size: 13px;
  }
  .image-container {
    padding-left: 25px;
    padding-right: 25px;
  }
}
</style>
