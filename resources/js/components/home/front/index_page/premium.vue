<template>
<div class="py-5" style=" background-color:#e0e0e057;">
    <h4 class="text-center ">Featured Products</h4>
   <div class="text-center mb-5"><hr class="line"></div>
   <div class="container">
    <v-container>
    <sliders style="margin:0px; padding:0px"
              :autoplay="true"
              :autoplayHoverPause="true"
              :scrollPerPage="true"
              :loop="true"
              :spacePadding="2"
              :navigationEnabled="true"
              :paginationEnabled="false"
              :responsive="true"
              :perPageCustom="[[300, 1], [500, 2],[600, 4]]"
              class="row"
    >
        <slide v-for="(k,index) in 12" :key="index" class="col-md-3 col-sm-6">
          <v-hover v-slot:default="{ hover }"
        open-delay="100">
          <v-card tile :elevation="hover ? 16 : 3" class=" text-center">
            <v-btn
              class="mt-3"
              absolute
              x-small
              dark
              fab
              left
              color="#270f0ea1"
            >
              <v-icon color="white" >favorite</v-icon>
            </v-btn>
            <!-- image part -->
            <v-img
                  class="white--text align-end"
                  height="200px"
                  src="https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/allbikes-1539286251.jpg?crop=0.985xw:1.00xh;0.00812xw,0&resize=1200:*"
                >
                <div class="ribbon ribbon-top-right"><span>FEATURED</span></div>
                <!-- price part -->
                <div class="text-center">
                      <v-chip class="chip"
                        height="17"
                        small
                        label      
                        color="#f2f2f2"
                      >
                        Rs. 120,00,000
                      </v-chip>
                </div>
              </v-img>

              <!-- date and user name part -->
            <div class="card-date">
              
                  <v-row >
                    <v-col class="text-left">
                        <v-chip
                          small
                          color="#f2f2f2"
                          text-color="dark"
                        >
                          <v-avatar left>
                            <v-icon small>mdi-alarm-check</v-icon>
                          </v-avatar>
                          1 day ago
                        </v-chip>
                    </v-col>
                    <v-col>
                        <v-chip
                          small
                          color="#f2f2f2"
                          text-color="dark"
                        >
                          <v-avatar left >
                            <v-icon small>mdi-account-circle</v-icon>
                          </v-avatar>
                          Bibek Raut
                        </v-chip>
                    </v-col>
                  </v-row>
                
            </div>

            <!-- title and subtitle part -->
            <v-card-text text-left>
              <div style="color:black">
                <h6>
                  This Is Subheading class
                </h6>
                
                </div>
              <div class="grey--text">person role</div>
            </v-card-text>
            <div class="card-date text-left">
              
              <p class="pa-2">
                <v-icon left small>location_on</v-icon>
                <small>Kathmandu Metro, Kathmandu</small>
                </p>
            </div>
          </v-card>
          </v-hover>
        
      
        </slide>
   </sliders>
   </v-container>
   </div>
</div>
</template>

<script>
import { Carousel, Slide } from 'vue-carousel';

export default {
  components: {
    'sliders':Carousel,
    Slide
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