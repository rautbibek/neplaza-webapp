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
                        <div  class="text-center mb-5" >
                            <v-chip class="category"
                            dark
                            color="#000000b3"
                            small
                            label
                            >
                            {{ads.scategory.name}}
                            
                            </v-chip>
                        </div>
                        
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
            </v-responsive>
    </div>
</template>
<script>

export default {
    props:['ads'],
    data(){
        return{
            //
        }
    }
}
</script>