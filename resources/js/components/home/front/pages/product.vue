<template>
    <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">All Ads</li>
            </ol>
        </nav>
      <div class="py-5">
        <v-container>
            <v-layout row wrap class="px-4">
            
                <v-flex xs12 sm6 md4 lg3 xl2 v-for="(ads,index) in all_ads" :key="index" >
                    <card-lazy :ads="ads"></card-lazy>
                </v-flex>
            
            </v-layout>
            <div class="text-center mt-5" v-if="nextUrl">

            <v-btn :loading="loading" outlined tile color="#2F3B59" class="" @click.prevent="fetch(nextUrl)">
                
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
    data(){
      return{
        isActive: false,
        loading:false,
        all_ads:[],
        color:'white',
        background:'#270f0ea1',
        name:'bibek',
        nextUrl : null,
      }
    },
    methods:{
      favorite(){
        if(this.$loggedIn){
            this.color= 'red';
            this.background= 'white';
        }else{
            EventBus.$emit('changeDialog', true);
        }
      },

      fetch(url){
          this.loading=true;
          axios.get(url)
               .then(({data}) =>{
                     this.all_ads.push(...data.data);
                     this.nextUrl = data.next_page_url
                     this.loading = false;
                 })
      }
    },
    created(){
        this.fetch(`front/all/product`);
    }

}
</script>