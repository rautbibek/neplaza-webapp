<template>
<v-card v-if="count>0" color="grey lighten-2" tile outlined>
  <v-container class="py-0">
    <v-card-title style="padding-bottom:0px">
      <!-- <v-btn icon >
        <v-icon color="#0c1963">assistant_photo</v-icon>
      </v-btn> -->
      Urgent ADS
      <v-spacer></v-spacer>
      <v-btn color="#0c1963" dark tile small router :to="`/urgent/sell`" v-if="count>3"  >
        view all
        <v-icon right>keyboard_arrow_right</v-icon>
      </v-btn>
    </v-card-title>

  </v-container>
  <v-divider style="padding:0px"></v-divider>
  <div class="py-3" >
    <!-- background-color:#e0e0e0;" -->
    <div>
      <!-- <h4 class="text-center ">Urgent Sell</h4>
     <div class="text-center mb-5"><hr class="line"></div> -->
    <v-container>
      <v-layout row wrap class="px-4">
          <v-overlay :value="overlay">
              <v-progress-circular indeterminate size="64"></v-progress-circular>
            </v-overlay>
              <v-flex xs12 sm6 md4 lg3 xl2 v-for="(ads,index) in all_ads" :key="index" >
                <card-lazy :ads="ads"></card-lazy>
              </v-flex>

      </v-layout>

    </v-container>
    </div>
  </div>
</v-card>
</template>
<script>
export default {
    data(){
      return{
        all_ads:[],
        overlay:false,
        count:0,
      }
    },
    methods:{
      favorite(){
        this.color= 'red';
        this.background= 'white';
      },
      getAds(){
        this.overlay = true;
        axios.get(`/urgent/ad`)
             .then(response =>{
                this.all_ads = response.data;
                this.count= this.all_ads.length;
                this.overlay = false;
              })
      }

    },

    created(){
        this.getAds();
    }
}
</script>
