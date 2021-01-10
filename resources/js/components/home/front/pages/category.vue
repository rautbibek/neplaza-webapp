<template>
    <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">{{category.name}}</li>
            </ol>
        </nav>
        <div>
        <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
        <!-- mobile view subcategoryt -->
        <div class="d-sm-none">
        <div >
            <div class="cover-image">
            <h3 class="text-center">{{category.name}}</h3>
           </div >
            <v-container class="cover-container create-ad">
            <v-list dense class="border">
                <v-list-item-group
                    color="primary"
                >
                    <v-list-item router :to="`/category/${category.id}/${scat.slug}`"
                    v-for="(scat, i) in category.scategory"
                    :key="i"
                    >
                    <v-list-item-icon>
                        <v-icon>keyboard_arrow_right</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title v-text="scat.name"></v-list-item-title>
                    </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
                </v-list>
            </v-container>
        </div>
        </div>
        <!-- end of mobile view subcategory -->
        <div class="py-5" v-if="count>0">

            <v-container>
                <v-layout row wrap class="px-1">
                
                <v-flex xs6 sm6 md4 lg3 xl2 v-for="(ads,index) in all_ads" :key="index" >
                    <card-lazy :ads="ads"></card-lazy>
                </v-flex>
                
                </v-layout>
                <div class="text-center mt-5" v-if="nextUrl">

                <v-btn :loading="loading" dark tile color="#2F3B59" class="" @click.prevent="more(nextUrl)">
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

export default {
    data(){
      return{
        overlay:true,
        loading:false,
        count:1,
        all_ads:[],
        category:{},
        nextUrl : null,
        items: [
        { text: 'Real-Time', icon: 'mdi-clock' },
        { text: 'Audience', icon: 'mdi-account' },
        { text: 'Conversions', icon: 'mdi-flag' },
      ],
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
                     this.category = data[1];
                     this.count = this.all_ads.length;
                     this.overlay= false;
            }).catch((error) => {
            if (error.response.status === 404) {
              window.location.href = '/pageNotFound'
            }
          });
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
        this.fetch(`/front/category/product/${this.$route.params.slug}`);
    },


    watch:{
      $route(to,from){
        return this.fetch(`/front/category/product/${this.$route.params.slug}`);
      }
    }

}
</script>