<template>
<div>
  <div class="py-5">
    <h4 class="text-center ">Recent Listing</h4>
   <div class="text-center mb-5"><hr class="line"></div>
  <v-container>
    <v-layout row wrap class="px-4">
        <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
          </v-overlay>
        <v-flex xs12 sm6 md4 lg3 xl2 v-for="(ads,index) in all_ads" :key="index" >
          <v-hover v-slot:default="{ hover }"
        open-delay="100">
        
          <v-card tile :elevation="hover ? 16 : 3" class="ma-3 text-center" >
          <!-- favorite component -->
            <favorite  :is_favorite='ads.is_favorite' :product_id="ads.id"></favorite>
            <!-- image part -->
            <router-link to="/user/create/ads">
            <v-img router :to="`/user/create/ads`" style="position:relative"
                  class="white--text align-end"
                  height="200px"
                  :src="ads.product_cover"
                >
                <!-- price part -->
                <router-link :to="`/category/${ads.category.slug}`" class="text-center mb-3">
                    <v-chip class="category"
                      dark
                      color="#000000b3"
                      small
                      label
                    >
                      {{ads.category.name}}
                      
                    </v-chip>
                </router-link>
                
                <!-- price part -->
                <div class="text-center mt-3">
                      <v-chip class="chip"
                        height="17"
                        small
                        label      
                        color="#f2f2f2"
                      >
                        Rs.{{ads.product_price}} {{ads.product_max_price}}
                      </v-chip>
                </div>
              </v-img>

              <!-- date and user name part -->
            <div class="card-date">
              
                  <v-row >
                    <v-col class="text-left">
                        <v-chip style="border-radius:none"
                          draggable
                          small
                          color="#f2f2f2"
                          text-color="dark"
                        >
                          <v-avatar left>
                            <v-icon small>mdi-alarm-check</v-icon>
                          </v-avatar>
                          {{ads.created_date}}
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
                          {{ads.user.name}}
                        </v-chip>
                    </v-col>
                  </v-row>
                
            </div>
            </router-link>

            <!-- title and subtitle part -->
            <v-card-text text-left>
              <div style="color:black">
                <h6>
                  {{ads.ad_title}}
                </h6>
                
                </div>
            </v-card-text>
            <div class="card-date text-left">
              
              <p class="pa-2">
                <v-icon left small>location_on</v-icon>
                <small>{{ads.nhood.name}}, {{ads.city.name}}</small>
                </p>
            </div>
          </v-card>
          </v-hover>
        </v-flex>
      
    </v-layout>
    <p class="text-center mt-3">
      <v-btn router :to="`/ads`" outlined tile color="#2F3B59" class="">
        
        view all
        <v-icon right>keyboard_arrow_right</v-icon>
      </v-btn>
    </p>
  </v-container>
  </div>
</div>
</template>
<script>
export default {
    data(){
      return{
        all_ads:[],
        overlay:false,
      }
    },
    methods:{
      favorite(){
        this.color= 'red';
        this.background= 'white';
      },
      getAds(){
        this.overlay = true;
        axios.get(`/front/all/product`)
             .then(({data}) =>{
                this.all_ads = data.data;
                this.overlay = false;
              })
      }

    },

    created(){
        this.getAds();
    }
}
</script>
