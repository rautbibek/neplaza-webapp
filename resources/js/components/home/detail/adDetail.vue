<template>
  <v-card>
    <div>
      <div class="">
        <nav aria-label="breadcrumb " >
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
      </div>

      <v-overlay :value="overlay" absolute>
        <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-overlay>
      <div>
        <div v-for="(ad, index) in detail" :key="index" >
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
  </v-card>
</template>
<script>
import adImage from  './displayImage';
import adUser from  './displayUserDetail';
import adDescription from  './displayDescription';
import adComment from  './displayComment';

export default {
  components:{
    'ad-image':adImage,
    'ad-user':adUser,
    'ad-description': adDescription,
    'ad-comment': adComment,
    
  },
  metaInfo: {
    title: 'Default App Title',
    
  },
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
      axios.get( `/product/detail/${this.$route.params.id}/${this.$route.params.slug}`)
        .then((response) => {
          this.detail = response.data;
          this.count = this.detail.length;
          this.category = response.data[0].category;
          this.scategory = response.data[0].scategory;
          this.productId = response.data[0].productid;
          this.$route.meta.title = this.detail[0].title
          this.$route.meta.metaTags[0].content = this.detail[0].title
          this.$route.meta.metaTags[1].content = this.detail[0].description
          this.overlay = false;
        }).catch((error) => {
            window.location.href = '/pageNotFound';
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
