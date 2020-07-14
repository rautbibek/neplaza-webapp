<template>
    <div>
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
        <div v-for="(ad,index) in detail" :key="index">
          <v-container> 
            <v-row>
                <v-col cols="12"  lg="8" >
                    <ad-image :images="ad.product_image"></ad-image>
                    <ad-description :ad="ad"></ad-description>
                </v-col>
                
                <v-col cols="12" lg="4">
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
</template>
<script>
export default {
    data(){
        return{
            overlay:false,
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