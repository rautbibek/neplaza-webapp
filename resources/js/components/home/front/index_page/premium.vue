<template>
<v-card v-if="count>0" outlined tile flat>
    <v-container class="py-0">
      <v-card-title style="padding-bottom:0px">
        <!-- <v-btn icon >
          <v-icon color="#0c1963">star</v-icon>
        </v-btn> -->
        Featured Ads
        <v-spacer></v-spacer>
        <v-btn color="#0c1963" small dark tile router :to="`/feature/ads`" v-if="count>6"  >
          view all
          <v-icon right>keyboard_arrow_right</v-icon>
        </v-btn>
      </v-card-title>

    </v-container>
    <v-divider style="padding:0px"></v-divider>
  <div class="" style=" " >
    <!-- <h4 class="text-center pt-2">Featured Products</h4>
     <div class="text-center mb-5"><hr class="line"></div> -->
     <div class="container">
      <v-container>
          <sliders style="margin:0px; padding:0px"
                :autoplay="true"
                :autoplayHoverPause="true"
                :scrollPerPage="false"
                :loop="true"
                :spacePadding="2"
                :navigationEnabled="true"
                :paginationEnabled="true"
                :responsive="true"
                :perPageCustom="[[300, 1], [500, 2],[600, 4]]"
                class="row"
            >
           <slide v-for="(feature,index) in featured" :key="index" class="col-md-3 col-sm-6" router :to="`/`">
            <v-hover v-slot:default="{ hover }"
             open-delay="100">
            <v-card tile :elevation="hover ? 16 : 3" class=" text-center">
              <v-btn style="margin-top:-10px; margin-left:5px"
                absolute
                small
                text
                left
              >
                <favorite :is_favorite='feature.favorite_to_users.length?true:false' :product_id="feature.id"></favorite>
              </v-btn>
              <!-- image part -->
              <router-link :to="`/ad/detail/${feature.id}/${feature.slug}`">
              <v-img
                    class="white--text align-end"
                    height="200px"
                    :src="feature.product_cover"
                  >
                  <div class="ribbon ribbon-top-right"><span>FEATURED</span></div>
                  <!-- category name part -->
                  <div class="text-center mb-3">
                                  <v-chip class="category"
                                  dark
                                  color="#000000b3"
                                  small
                                  label
                                  >
                                  <span v-if="feature.product_property.status_name">Status : {{feature.product_property.status_name}}</span>
                                  <span v-else>{{feature.product_property.scategory_name}}</span>

                                  </v-chip>
                              </div>
                  <!-- price part -->
                  <div class="text-center">
                    <v-alert style="opacity:0.9; padding-top:0px" height="25px" shaped color="red" elevation="20" dark prominent max-width="200px" dense>
                      Rs. {{feature.product_price}} {{feature.product_max_price}}
                    </v-alert>
                 </div>

                </v-img>

                <!-- date and user name part -->
                      <div class="card-date">
                          <card-date :ads="feature"></card-date>
                      </div>

                      <!-- title and subtitle part -->
                      <card-title :ads="feature"></card-title>
              </router-link>
            </v-card>
            </v-hover>


          </slide>
     </sliders>

     </v-container>

     </div>
  </div>
</v-card>
</template>

<script>
import { Carousel, Slide } from 'vue-carousel';

export default {
  components: {
    'sliders':Carousel,
    Slide
  },
  data(){
    return{
      featured:[],
      count:0,
    }
  },
  methods:{
    getFeatured(){
      axios.get(`/front/featured/product`)
            .then(response=>{
              this.featured = response.data;
              this.count = this.featured.length;
            })
    }
  },
  created(){
    return this.getFeatured();
  }
};
</script>

<style scoped>

.ribbon {
    width: 110px;
    height: 111px;
    overflow: hidden;
    position: absolute;
}
.ribbon::before,
.ribbon::after {
    position: absolute;
    z-index: -1;
    content: '';
    display: block;
    border: 5px solid #cf0000;
}
.ribbon span {
    position: absolute;
    display: block;
    width: 198px;
    padding: 6px 0;
    background-color: #cf0000;
    box-shadow: 0 5px 10px rgba(0,0,0,.1);
    color: #fff;
    text-shadow: 0 1px 1px rgba(0,0,0,.2);
    text-transform: uppercase;
    text-align: center;
    font-size: 14px;
}
/* top right*/
.ribbon-top-right {
    top: -13px;
    right: -13px;
}
.ribbon-top-right::before,
.ribbon-top-right::after {
    border-top-color: transparent;
    border-right-color: transparent;
}
.ribbon-top-right::before {
    top: 0;
    left: 0;
}
.ribbon-top-right::after {
    bottom: 0;
    right: 0;
}
.ribbon-top-right span {
    left: -30px;
    top: 30px;
    transform: rotate(45deg);
}

  .card-date{
    height: 40px;
    border-bottom:1px solid #f2f2f2
  }

</style>
