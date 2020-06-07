<template>
    <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">{{category.name}}</li>
            </ol>
        </nav>
        <div>
        <div class="py-5" v-if="count>0">

            <v-container>
                <v-layout row wrap class="px-4">
                
                <v-flex xs12 sm6 md4 lg3 xl2 v-for="(ads,index) in all_ads" :key="index" >
                    <v-hover v-slot:default="{ hover }"
                    open-delay="100">
                    
                    <v-card tile :elevation="hover ? 16 : 3" class="ma-3 text-center" >
                        <favorite position="right" :is_favorite='ads.is_favorite' :product_id="ads.id"></favorite>
                        <!-- image part -->
                        <v-img style="position:relative"
                            class="white--text align-end"
                            height="200px"
                            :src="ads.product_cover"
                            >
                            <!-- category name -->
                            <div class="text-center mb-3">
                                <v-chip class="category"
                                dark
                                color="#000000b3"
                                small
                                label
                                >
                                {{ads.scategory.name}}
                                
                                </v-chip>
                            </div>
                            
                            <!-- price part -->
                            <div class="text-center">
                                <v-chip class="chip"
                                    height="17"
                                    small
                                    label      
                                    color="#f2f2f2"
                                >
                                    Rs. {{ads.product_price}} {{ads.product_max_price}}
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

export default {
    data(){
      return{
        loading:false,
        count:1,
        all_ads:[],
        category:{},
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
          
          axios.get(url)
               .then(({data}) =>{
                     this.all_ads = data[0].data;
                     this.nextUrl = data[0].next_page_url
                     this.category = data[1];
                     this.count = this.all_ads.length;
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
        this.fetch(`/front/category/product/${this.$route.params.slug}`);
    },


    watch:{
      $route(to,from){
        return this.fetch(`/front/category/product/${this.$route.params.slug}`);
      }
    }

}
</script>