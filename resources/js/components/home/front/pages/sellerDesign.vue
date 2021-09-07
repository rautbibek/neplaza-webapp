<template>
    <div >
        <!-- <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">{{seller_detail.name}}</li>
            </ol>
        </nav> -->
        <v-overlay :value="overlay" absolute>
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
        <div >
            <div class="banner" >
                <img class="banner-image" src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b6/Image_created_with_a_mobile_phone.png/1200px-Image_created_with_a_mobile_phone.png" alt="cover">
            </div>
          <div >

                <div class="container user_detail">
                    <v-row justify="center" style="height:70px">
                        <v-avatar size="140" style="top:-70px; border:5px solid white">
                            <img
                                :src="seller_detail.cover"
                                :alt="seller_detail.name"/>
                        </v-avatar>
                    </v-row>
                  <div class="container text-center">
                       <v-card-title style="justify-content: center; padding:10px">Bibek Raut</v-card-title>
                        <v-card-subtitle class="text-center text-grey" style="font-size:12px; color:grey">4th june 2025</v-card-subtitle>
                        <p style="text-align:left; font-size:15px; font-weight:400">In linguistics and grammar, a sentence is a linguistic expression such as the English example
                            "The quick brown fox jumps over the lazy dog." In traditional grammar, it is typically
                            defined as a string of words that
                            expresses a complete thought, or as a unit consisting of a subject and predicate</p>
                    </div>
                    <div class="container text-right">
                        <v-btn

                            color="#2f3b59"
                            style="color:white"
                            >
                            <v-icon left>
                                mdi-chat
                            </v-icon>
                            message
                        </v-btn>
                        <v-btn

                            color="#2f3b59"
                            style="color:white"
                            >
                            <v-icon left>
                                mdi-phone
                            </v-icon>
                            call
                        </v-btn>
                    </div>

                </div>
            <div class="container">
                <v-col class="product_detail">
                    <v-layout row wrap >
                        <v-flex xs6 sm6 md3 lg3 xl3 v-for="(ads,index) in all_ads" :key="index" >
                            <card-lazy :ads="ads"></card-lazy>
                        </v-flex>

                    </v-layout>
                    <div class="text-center ma-5" v-if="nextUrl">

                    <v-btn :loading="loading" outlined color="#2F3B59" @click.prevent="more(nextUrl)">
                        Load More
                        <template v-slot:loader>
                            <span>Loading...</span>
                        </template>
                        <v-icon right>cached</v-icon>
                    </v-btn>
                </div>
                </v-col>
            </div>
         </div>
        </div>
    </div>
</template>
<script>
import Message from '../../detail/Message';
export default {
  components:{
      Message,
  },
 data(){
     return{
         overlay:false,
         seller_detail:{},
         all_ads:[],
         loading:false,
         count:1,
         nextUrl : null,
     }
 },
 methods:{
     seller(){
         this.overlay= true;
         axios.get(`/seller/detail/${this.$route.params.id}/${this.$route.params.username}`)
              .then(response =>{

                  this.seller_detail = response.data;
                  this.overlay = false;
              })
              .catch()
     },
     fetch(url){
          this.overlay=true;
          axios.get(url)
               .then(({data}) =>{
                     this.all_ads = data.data;
                     this.nextUrl = data.next_page_url;
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
      this.seller();
      this.fetch(`/seller/${this.$route.params.id}/ad`);
  },

}
</script>
<style scoped>
.content{



}
.banner{
    height: 300px;
    width:100%;
    object-fit: cover;
    background-size: cover;
    background-repeat: no-repeat;
    position:relative;
    background: rgb(185, 187, 185);
    /* background-image:url('https://upload.wikimedia.org/wikipedia/commons/thumb/b/b6/Image_created_with_a_mobile_phone.png/1200px-Image_created_with_a_mobile_phone.png'); */

}
.user_detail{
    min-height: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    /* box-shadow: 10px 10px 24px -13px rgba(0,0,0,0.75);
    -webkit-box-shadow: 10px 10px 24px -13px rgba(0,0,0,0.75);
    -moz-box-shadow: 10px 10px 24px -13px rgba(0,0,0,0.75); */

    background: white;
}
.product_detail{
    min-height: 50px;
    border-radius: 10px;
    /* box-shadow: 10px 10px 24px -13px rgba(0,0,0,0.75);
    -webkit-box-shadow: 10px 10px 24px -13px rgba(0,0,0,0.75);
    -moz-box-shadow: 10px 10px 24px -13px rgba(0,0,0,0.75); */
}
.banner-image{
    height:300px; ;
    object-fit: cover;
    width: 100%;
}


</style>
