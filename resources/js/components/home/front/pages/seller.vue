<template>
    <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">{{seller_detail.name}}</li>
            </ol>
        </nav>
        <v-overlay :value="overlay" absolute>
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
        <div >
          <div class="container-fluid px-5">
            <v-row >
                <v-col cols="12" lg="3" sm="4" md="3">
                    <v-card tile class="mt-3 text-center" >
                        <v-col class="">
                            <v-responsive>
                                <v-avatar size="120">
                                <img
                                    :src="seller_detail.cover"
                                    :alt="seller_detail.name"
                                >
                                </v-avatar>
                            </v-responsive>
                        
                        </v-col>

                        <v-list-item-content class="text-center">
                        <v-list-item-title>{{seller_detail.name}}</v-list-item-title>
                        <small style="color:grey" class="my-1" >user since : {{seller_detail.register_date}}</small>
                        </v-list-item-content>
                        
                        
                    </v-card>
                    <v-card tile class="mt-3 pa-3" v-if="seller_detail.city">
                            <h5 class="m-2 text-center"><i class="fa fa-map-marker"> </i> Address Location </h5>
                            <hr>
                            <div class="row">
                                <div class="col-6"> Located District :</div>
                                <div class="col-6">{{seller_detail.city.name}}</div>
                            </div>
                            <div class="row">
                                <div class="col-6">Metro/Municipility/VDC :</div>
                                <div class="col-6">{{seller_detail.nhood.name}}</div>
                            </div>
                    </v-card>
                    <!-- contact number -->
                    <v-card class="mt-3 pa-3">
                      
                        <v-list-item-content class="text-center">
                        <v-list-item-title class="mt-2">
                            Contact Number :
                            <v-icon small color="green"> phone</v-icon>
                            
                            <a :href="'tel:'+seller_detail.contact_number">{{ seller_detail.contact_number}} </a>
                        </v-list-item-title>
                        </v-list-item-content>
                        

                        <v-card-text class="text-center" style="background-color:#3f51b5" v-if="seller_detail.hide_contact ==true">

                            <small class="my-1 text-white">Seller Set the Contact {{seller_detail.contact_status}}</small>
                        </v-card-text>
                    </v-card>
                    <Message class="d-none d-sm-flex" :seller="seller_detail"/>
                </v-col>

                
                <v-col cols="12"  lg="9" sm="8" md="9"> 

                    <!-- <v-card class="mt-3" tile v-if="seller_detail.about">
                        <v-card-title>
                            About {{seller_detail.name}}
                        </v-card-title>
                        <v-card-text>
                            <blockquote>{{seller_detail.about}}</blockquote>
                        </v-card-text>
                    </v-card> -->
                    <v-layout row wrap class="mt-2 px-1">
                        <v-flex xs6 sm6 md4 lg3 xl3 v-for="(ads,index) in all_ads" :key="index" >
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


            </v-row>
            <v-footer padless elevation="10"  fixed class="d-flex d-sm-none">
              <v-btn tile dark style="width:100%" color="#2f3b59">
                <Message :seller="seller_detail"/>
              </v-btn>
            
          </v-footer> 
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
                console.log(response.data);
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
  }
}
</script>
