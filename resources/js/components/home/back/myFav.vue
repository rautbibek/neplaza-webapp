<template>
    <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">Favorite Ads</li>
            </ol>
        </nav>
        <v-overlay :value="overlay">
                <v-progress-circular indeterminate size="64"></v-progress-circular>
            </v-overlay>
      <div class="py-5">
        <v-container>
            <v-layout row wrap class="px-4">
            
                <v-flex xs12 sm6 md4 lg3 xl2 v-for="(ads,index) in fav_ads" :key="index" >
                <v-hover v-slot:default="{ hover }"
                open-delay="100">
                    <v-card tile :elevation="hover ? 16 : 3" class="ma-3 text-center" >
                        <div @click='remove(index)'>
                        <favorite :is_favorite='ads.is_favorite' :product_id="ads.id" ></favorite>
                        </div>
                        <!-- image part -->
                        <v-img style="position:relative" 
                            class="white--text align-end"
                            height="200px"
                            :src="ads.product_cover"
                            >
                            <!-- category name part -->
                                                    
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
            
        </v-container>
      </div>
    </div>
</template>
<script>

export default {
    data(){
      return{
        overlay:false,
        fav_ads:[],
        count:'',
      }
    },
    methods:{
      fetch(){
          this.overlay = true;
          if(!this.loggedIn){
                this.$router.push("/");
                EventBus.$emit('changeDialog', true);
                return;
            }
          axios.get(`/user/favorite/product`)
               .then(response =>{
                   this.overlay = false;
                     this.fav_ads= response.data[0].favourit_products;
                 })
      },

      remove(index){ 
        this.fav_ads.splice(index);
        this.fetch();
      }

    },
    created(){
        this.fetch();
    }

}
</script>