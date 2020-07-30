<template>
<div>
    <div v-if="count>0">
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">{{category}}</li>
                <li class="breadcrumb-item active" aria-current="page">{{scategory}}</li>
                <li class="breadcrumb-item active" aria-current="page">{{productId}}</li>
            </ol>
        </nav>
        
        <v-overlay :value="overlay" absolute>
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
        <div>
            <div v-for="(ad,index) in detail" :key="index">
            <v-container> 
                <v-row>
                    <v-col cols="12"  lg="8" md="8" sm="12" xs="12" >
                        <ad-image :images="ad.product_image"></ad-image>
                        <ad-description :ad="ad"></ad-description>
                    </v-col>
                    
                    <v-col cols="12" lg="4" md="4">
                        <ad-user :ad="ad" :owner="ad.user"></ad-user>
                    </v-col>
                    
                </v-row>
                <v-row>
                    <v-col cols="12" lg="8" md="8" sm="12" xs="12">
                        <ad-comment :product_id="ad.id"></ad-comment>
                    </v-col>
                </v-row>
            </v-container>
            </div>
        </div>
    </div>
    <div v-else>
        <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">404 page not found</li>
            </ol>
        </nav>
        <v-container>
            <div class="container">
                
                    <v-card dense tile flat 
                        max-width="344"
                        class="mx-auto"
                        
                    >
                        <h4  class="text-center" style="font-size:50px; color:indigo">Oops !</h4>
                        <p class="text-center mt-3" style=" font-size:20px">
                           We can't seem to find the ad your are looking for.
                        </p>
                        <!-- <v-img
                            src="/storage/404.png"
                            height="194"
                        ></v-img> -->

                        <div class="text-center" >
                            <v-btn router to="/"
                                dark
                                tile
                                color="deep-purple accent-4"
                            >
                                Back to homepage
                            </v-btn>
                        </div>
                    </v-card>
                
            </div>
        </v-container>
    </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return{
            overlay:false,
            count:'1',
            detail:[],
            images:{},
            owner:{},
            category:'',
            scategory:'',
            productId:'',
            fav_count:null,
        }
    },
    methods:{
        getAd(){
            this.overlay= true;
            axios.get(`/product/detail/${this.$route.params.id}`)
                 .then(response =>{
                     this.detail = response.data;
                     this.count = this.detail.length;
                     this.category= response.data[0].category.name;
                     this.scategory= response.data[0].scategory.name;
                     this.productId = response.data[0].productid;
                     this.overlay = false;
                 })
        }
    },
    created(){
        this.getAd();
    },
    watch:{
      $route(to,from){
        return this.getAd();
      }
    }
}
</script>