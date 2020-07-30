<template>
<div  class="mb-3">
    <v-card tile v-if="total_image>0"> 
      
        <v-col> 
          <vue-easy-lightbox
            :visible="visible"
            :imgs="imgs"
            @hide="handleHide"
          ></vue-easy-lightbox>
            <v-row align="center" no-gutters justify="center" class="pa-1">
              
              <v-col elevation="10" >
                <v-img elevation="10" @click="() => showImg(img_id)"
                  :src="images[img_id].full_image"
                  :lazy-src="images[img_id].full_image"
                  aspect-ratio="1"
                  class="grey lighten-2 border"
                  contain
                  max-width="100%"
                  max-height="390"
                  >
                 
                  <template v-slot:placeholder>
                      <v-row
                      class="fill-height ma-0"
                      align="center"
                      justify="center"
                      >
                      <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                      </v-row>
                  </template>
                   <div  class="ml-3 mt-5" style="position:relative;">
                       <v-chip
                       dark
                       color="#000000b3"
                       
                       label
                       >
                       {{img_id+1}} / {{total_image}} 
                       <v-icon right small>image</v-icon>
                       </v-chip>
                    </div>
                    
                </v-img>
                <a class="next" @click="nextSlides" v-if="last_slide">&#10095;</a>
                <a class="prev" @click="prevSlides" v-if="first_slide">&#10094;</a>
                
              </v-col>
            </v-row> 
            <v-row no-gutters>
            <v-col 
              v-for="(image,index) in images"
              :key="index"
              class="d-flex child-flex px-1 pb-1"
              cols="2" md="1" sm="1" lg="1" xs="2"
            >
              <v-card :style="index == img_id ?'opacity:0.5':''" flat tile class="d-flex border" elevation="10" @click="selected_image(index)">
                
                <v-img 
                  :src="image.thumb_image"
                  :lazy-src="image.thumb_image"
                  aspect-ratio="1"
                  class="grey lighten-2"
                >
                  <template v-slot:placeholder>
                    <v-row
                      class="fill-height ma-0"
                      align="center"
                      justify="center"
                    >
                      <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                    </v-row>
                  </template>
                </v-img>
              </v-card>
            </v-col>
          </v-row>
        </v-col>  
          
    </v-card> 
    <v-card tile v-else> 
        <v-col> 
            <v-row align="center" justify="center" class="pa-1">
              <v-col cols="12" elevation="10">
                <v-img 
                  :src="'/storage/noimage.png'"
                  :lazy-src="'/storage/noimage.png'"
                  aspect-ratio="1"
                  class="grey lighten-2 border"
                  contain
                  max-width="720"
                  max-height="390"
                  >
                  <template v-slot:placeholder>
                      <v-row
                      class="fill-height ma-0"
                      align="center"
                      justify="center"
                      >
                      <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                      </v-row>
                  </template>
                </v-img>
              </v-col>
            </v-row> 
        </v-col>    
    </v-card>   
</div>
</template>
<script>
// use the component
import Vue from 'vue'
import Lightbox from 'vue-easy-lightbox'

Vue.use(Lightbox)
export default {
  
    props:['images'],
    data(){
        return{
            visible: false,
            imgs: [],
            index: 0,   // default
            img_id:0,
        }
    },
    methods:{
        selected_image(id){
            this.img_id = id;
        },
        nextSlides(){
          this.img_id++;
        },
        prevSlides(){
          this.img_id--;
        },
        showImg (index) {
          this.index = index
          this.visible = true
        },
        handleHide () {
          this.visible = false
        },
    },
    computed:{
        total_image(){
            return this.images.length;
        },
        last_slide(){
          return this.img_id == this.images.length-1 ? false : true;
        },
        first_slide(){
          return this.img_id == 0 ? false : true;
        }
    },
    mounted(){
      var i;
      for (i = 0; i < this.images.length; i++) {
        this.imgs.push(this.images[i].full_image);
      }
    }

}
</script>
<style scoped>
    .scroll {
        background-color: #ddd;
        overflow-y: auto;
        white-space: nowrap;
    }

.cursor {
  cursor: pointer;
}

/* Next & previous buttons */
.prev,
.next {
  cursor: pointer;
  position: absolute;
  top: 55%;
  width: auto;
  padding: 10px;
  margin-top: -50px;
  color: rgb(53, 23, 23);
  font-weight: bold;
  font-size: 20px;
  border-radius: 0 3px 3px 0;
  user-select: none;
  -webkit-user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
  background-color: rgba(0, 0, 0, 0.8);
  color:white;
}
</style>