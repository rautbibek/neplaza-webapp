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
              <card-lazy :ads="ads"></card-lazy>
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
        axios.get(`/front/home/product`)
             .then(response =>{
                this.all_ads = response.data;
                console.log(this.all_ads);
                this.overlay = false;
              })
      }

    },

    created(){
        this.getAds();
    }
}
</script>
