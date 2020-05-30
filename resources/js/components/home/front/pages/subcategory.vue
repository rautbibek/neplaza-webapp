<template>
<div class="py-5">
    <h4 class="text-center ">Recent Listing</h4>
   <div class="text-center mb-5"><hr class="line"></div>
  <v-container>
    <v-layout row wrap class="px-4">
      
        <v-flex xs12 sm6 md4 lg3 xl2 v-for="(k,index) in 12" :key="index" >
          <v-hover v-slot:default="{ hover }"
        open-delay="100">
        
          <v-card tile :elevation="hover ? 16 : 3" class="ma-3 text-center">
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
                  src="https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/allbikes-1539286251.jpg?crop=0.985xw:1.00xh;0.00812xw,0&resize=1200:*"
                >
                <!-- price part -->
                <div class="text-center mb-3">
                    <v-chip class="category"
                      dark
                      color="#000000b3"
                      small
                      label
                    >
                      For Sale : Houses & Apartments
                      
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
                        Rs. 120,00,000
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
                          1 day ago
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
                          Bibek Raut
                        </v-chip>
                    </v-col>
                  </v-row>
                
            </div>

            <!-- title and subtitle part -->
            <v-card-text text-left>
              <div style="color:black">
                <h6>
                  This Is Subheading class
                </h6>
                
                </div>
              <div class="grey--text">person role</div>
            </v-card-text>
            <div class="card-date text-left">
              
              <p class="pa-2">
                <v-icon left small>location_on</v-icon>
                <small>Kathmandu Metro, Kathmandu</small>
                </p>
            </div>
          </v-card>
          </v-hover>
        </v-flex>
      
    </v-layout>
    <p class="text-center mt-3">
      <v-btn outlined tile color="#2F3B59" class="">
        
        view all
        <v-icon right>keyboard_arrow_right</v-icon>
      </v-btn>
    </p>
  </v-container>
  </div>
</template>
<script>
export default {
    data(){
      return{
        color:'white',
        background:'#270f0ea1',
        name:'bibek',
      }
    },
    methods:{
      favorite(){
        this.color= 'red';
        this.background= 'white';
      }
    }
}
</script>
