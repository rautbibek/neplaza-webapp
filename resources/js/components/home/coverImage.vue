<template>
    <div>
        <v-responsive>
        <v-img style="position:relative"
                        class="white--text align-end"
                         height="200px"
                        :src="ads.product_cover"
                        :lazy-src="ads.product_cover"
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
                        <!-- price part -->
                        <div class="text-center ma-5">
                            <v-chip class="category"
                            dark
                            color="#000000b3"
                            small
                            label
                            >
                            <span v-if="ads.product_property.status_name">Status : {{ads.product_property.status_name}}</span>
                            <span v-else>{{ads.product_property.scategory_name}}</span>
                            </v-chip>
                        </div>

                        <!-- price part -->
                         <div class="text-center">
                           <v-alert style="opacity:0.9; padding-top:0px" height="25px" shaped color="#303c5a" elevation="20" dark prominent max-width="200px" dense>
                             Rs. {{ads.product_price}} {{ads.product_max_price}}
                           </v-alert>
                        </div>

                    </v-img>
            </v-responsive>
    </div>
</template>
<script>

export default {
    props:['ads'],
    data(){
        return{
            show:true,
        }
    },
    mounted(){
      // if(this.$route.params.id == this.ads.scategory_id){
      //   return this.show =false;
      // }
    }
}
</script>
