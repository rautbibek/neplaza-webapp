<template>
    <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">Urgent sell</li>
            </ol>
        </nav>
        <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
      <div class="">
        <v-container>
            <v-layout row wrap>
            
                <v-flex xs6 sm6 md4 lg3 xl2 v-for="(ads,index) in all_ads" :key="index" >
                    <card-lazy :ads="ads"></card-lazy>
                </v-flex>
            
            </v-layout>
            <div class="text-center mt-5" v-if="nextUrl">

            <v-btn :loading="loading" outlined tile color="#2F3B59" class="" @click.prevent="more(nextUrl)">
                
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
        overlay:false,
        all_ads:[],
        color:'white',
        background:'#270f0ea1',
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
          this.overlay= true
          this.loading=true;
          axios.get(url)
               .then(({data}) =>{
                     this.all_ads.push(...data.data);
                     this.nextUrl = data.next_page_url
                     this.loading = false;
                     this.overlay = false;
                 })
      },
      more(nextUrl){
        this.loading=true;
        axios.get(nextUrl)
             .then(({data}) =>{
                this.all_ads.push(...data.data);
                this.nextUrl = data.next_page_url
                this.loading = false;
            })
      }
    },
    created(){
        this.fetch(`/front/urgent/product`);
    }

}
</script>