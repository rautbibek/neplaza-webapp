<template>
    <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">Search</li>
                <li class="breadcrumb-item active" style="color:red" aria-current="page">Keyword - "{{this.$route.query.q}}"</li>
                
            </ol>
        </nav>
        <div>
        <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
        
        <div class="py-5" v-if="count>0">
                <h4 class="text-center">Search Results</h4>
                <div class="text-center mb-5"><hr class="line"></div>
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
        <div v-else>
            <empty></empty>
        </div>
        </div>
    </div>
</template>
<script>
  export default{
    data(){
      return{
        loading:false,
        overlay:false,
        all_ads:{},
        count:1,
        nextUrl : null,
      }
    },
    methods:{
      fetch(url){
          this.overlay=true;
          axios.get(url)
               .then(({data}) =>{
                     this.all_ads = data.data;
                     this.nextUrl = data.next_page_url;
                     this.count = this.all_ads.length;
                     this.overlay= false;
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
    watch:{
      $route(to,from){
        //this.getSearch();
        //console.log(this.cat_posts);
        this.fetch(`/searchResult/?q=${this.$route.query.q}`);
      }
    },
    created(){
      this.fetch(`/searchResult/?q=${this.$route.query.q}`);
    }
}
</script>