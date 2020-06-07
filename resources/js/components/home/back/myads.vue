<template>
    <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">My Ads</li>
            </ol>
        </nav>
      <div class="py-5" v-if="count>0">
        <v-container>
            <v-layout row wrap class="px-4">
            
                <v-flex xs12 sm6 md4 lg3 xl2 v-for="(ads,index) in my_ads" :key="index" >
                <v-hover v-slot:default="{ hover }"
                open-delay="100">
                
                <v-card tile :elevation="hover ? 16 : 3" class="ma-3 text-center">
                    <favorite :is_favorite='ads.is_favorite' :product_id="ads.id"></favorite>
                    <!-- image part -->
                    <v-img style="position:relative" 
                        class="white--text align-end"
                        height="200px"
                        :src="ads.product_cover"
                        >
                        <!-- price part -->
                        <router-link :to="`/category/${ads.category.slug}`" class="text-center mb-5" >
                            <v-chip class="category" router :to='`/`'
                            dark
                            color="#000000b3"
                            small
                            label
                            >
                            {{ads.category.name}}
                            
                            </v-chip>
                        </router-link>
                        
                        <!-- price part -->
                        <div class="text-center mt-3">
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
      <div v-else>
            <empty></empty>
        </div>
    </div>
</template>
<script>

export default {
    data(){
      return{
        loading:false,
        my_ads:[],
        nextUrl : null,
        count:1,
      }
    },
    methods:{
      fetch(url){
          if(!this.loggedIn){
                this.$router.push("/");
                EventBus.$emit('changeDialog', true);
                return;
            }
          this.loading=true;
          axios.get(url)
               .then(({data}) =>{
                     this.my_ads.push(...data.data);
                     this.count = this.my_ads.length;
                     this.nextUrl = data.next_page_url
                     this.loading = false;
                 })
      }
    },
    created(){
        this.fetch(`/user/product/myads`);
    }

}
</script>