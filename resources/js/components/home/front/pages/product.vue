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
                <v-hover v-slot:default="{ hover }"
                open-delay="100">
                
                <v-card tile :elevation="hover ? 16 : 3" class="ma-3 text-center" router :to='`/`'>
                    <v-btn @click="favorite"
                    class="mt-3"
                    absolute
                    x-small
                    dark
                    fab
                    right
                    :color="background"
                    >
                    <v-icon :color="color"  >mdi-heart</v-icon>
                    </v-btn>
                    <!-- image part -->
                    <v-img style="position:relative"
                        class="white--text align-end"
                        height="200px"
                        :src="ads.product_cover"
                        >
                        <!-- price part -->
                        <div class="text-center mb-3">
                            <v-chip class="category"
                            dark
                            color="#000000b3"
                            small
                            label
                            >
                            {{ads.category.name}}
                            
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