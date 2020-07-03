<template>
    <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">My Ads</li>
            </ol>
        </nav>
      <div class="py-3">
          <v-overlay :value="overlay">
                <v-progress-circular indeterminate size="64"></v-progress-circular>
            </v-overlay>
        <v-container>
            <v-row wrap class="px-4">
                <v-col cols="12" xs="12" sm="6" lg="3" md="3"><mymenu></mymenu></v-col>
                <v-col cols="12" xs="12" sm="6" lg="9" md="9">  
                    <div v-if="count>0">
                        <v-layout row wrap>
                            <v-flex xs12 sm12 md4 lg4 xl2 v-for="(ads,index) in my_ads" :key="index" >
                                <v-hover v-slot:default="{ hover }"
                                open-delay="100">
                                    <v-lazy
                                        v-model="isActive"
                                        :options="{
                                        threshold: .5
                                        }"
                                        min-height="200"
                                        transition="fade-transition"
                                    >
                                        <v-card tile :elevation="hover ? 16 : 3" class="ma-3 text-center">
                                            <card-menu :ads="ads"></card-menu>
                                            <!-- image part -->
                                            <router-link :to="`/ad/detail/${ads.id}`">
                                            <cover :ads="ads"></cover>

                                            <!-- date and user name part -->
                                            <div class="card-date">
                                            
                                                <card-date :ads="ads"></card-date>
                                                
                                            </div>

                                            <!-- title and subtitle part -->
                                            <card-title :ads="ads"></card-title>
                                            </router-link>
                                        </v-card>
                                    </v-lazy>
                                </v-hover>
                            </v-flex>
                
                        </v-layout>
                    </div>
                    <div v-else>
                        <empty></empty>
                    </div>
                </v-col>
            </v-row>
            
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
        overlay:true,
        isActive: false,
        loading:false,
        my_ads:[],
        nextUrl : null,
        count:1,
      }
    },
    methods:{
      fetch(url){
          this.overlay= true
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
                     this.overlay = false;
                 })
                 
      }
    },
    created(){
        this.fetch(`/user/product/myads`);
    }

}
</script>