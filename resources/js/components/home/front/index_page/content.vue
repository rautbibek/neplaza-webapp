<template>
<v-card tile flat>
  <v-container class="py-0">
    <v-card-title style="padding-bottom:0px">
      <!-- <v-btn icon >
        <v-icon color="#0c1963">how_to_vote</v-icon>
      </v-btn> -->
      Recent Listing
      <v-spacer></v-spacer>
      <!-- <v-btn color="#d20f09" dark small router :to="`/ads`" v-if="count>3"  >
        view all
        <v-icon right>keyboard_arrow_right</v-icon>
      </v-btn> -->
    </v-card-title>

  </v-container>
<v-divider style="padding:0px"></v-divider>
  <div>
    <!-- <h4 class="text-center ">Recent Listing</h4>
   <div class="text-center mb-3"><hr class="line"></div> -->
  <v-container>
    <v-layout row wrap class="px-4">
        <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
          </v-overlay>
            <v-flex xs12 sm6 md3 lg3 xl2 v-for="(ads,index) in all_ads" :key="index">
              <card-lazy :ads="ads"></card-lazy>
            </v-flex>

    </v-layout>
<update-profile></update-profile>
    <p class="text-center mt-5">
      <v-btn class="mt-3" color="#0c1963" small router :to="`/ads`" dark >
        view all
        <v-icon right>keyboard_arrow_right</v-icon>
      </v-btn>
    </p>
  </v-container>
  </div>
</v-card>
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
        axios.get(`/front/home/product`)
             .then(response =>{
                this.all_ads = response.data;
                this.overlay = false;
              })
      }

    },

    created(){
        this.getAds();
    }
}
</script>
