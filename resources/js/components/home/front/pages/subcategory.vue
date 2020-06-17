<template>
    <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item pull-right">
                  <router-link :to="`/category/${category_slug}`">
                    {{category_name}}
                  </router-link></li>
                <li class="breadcrumb-item active" aria-current="page">{{scategory.name}}</li>
            </ol>
        </nav>
        <div>
        <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
        <div class="py-2" v-if="count>0">
            <v-content>
                <v-row wrap no-gutters class="px-2">
                  <v-col cols="3"> 
                    <nav-filter></nav-filter> 
                  </v-col>
                  <v-col cols="9" > 
                    <div>
                      <v-layout row wrap class="px-4"> 
                        <v-flex xs12 sm6 md4 lg4 xl3 v-for="(ads,index) in all_ads" :key="index" >
                            <card-lazy :ads="ads"></card-lazy>
                        </v-flex>
                      </v-layout>
                    </div>
                  </v-col>
                </v-row>
                <div class="text-center mt-5" v-if="nextUrl">
                      <v-btn :loading="loading" outlined tile color="#2F3B59" class="" @click.prevent="more(nextUrl)">
                          Load More
                          <template v-slot:loader>
                              <span>Loading...</span>
                          </template>
                          <v-icon right>cached</v-icon>
                      </v-btn>
                  </div>
            </v-content>
        </div>
        <div v-else>
            <empty></empty>
        </div>
        </div>
    </div>
</template>
<script>

export default {
    data(){
      return{
        overlay:true,
        loading:false,
        count:1,
        all_ads:[],
        scategory:{},
        category_name:'',
        category_slug:'',
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
          this.overlay=true;
          axios.get(url)
               .then(({data}) =>{
                     this.all_ads = data[0].data;
                     this.nextUrl = data[0].next_page_url
                     this.scategory = data[1];
                     this.category_name = this.scategory.category.name;
                     this.category_slug = this.scategory.category.slug;
                     //this.count = this.all_ads.length;
                     this.all_ads = data[0].data;
                     this.overlay= false;
            })
      },
      more(nextUrl){
        this.loading=true;
        axios.get(nextUrl)
             .then(({data}) =>{
                this.all_ads.push(...data[0].data);
                this.nextUrl = data[0].next_page_url
                this.loading = false;
            })
      }
    },
    created(){
        //alert(this.$route.params.slug)
        this.fetch(`/front/scategory/product/${this.$route.params.slug}`);
    },


    watch:{
      $route(to,from){
        return this.fetch(`/front/scategory/product/${this.$route.params.slug}`);
      }
    }

}
</script>