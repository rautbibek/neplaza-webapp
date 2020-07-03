<template>
    <div>
        <v-card tile>
            <v-col>
                <v-row align="center" justify="center">
                    <v-carousel height="410" class="border">
                        <v-carousel-item
                        v-for="(item,i) in images"
                        :key="i"
                        :src="'/storage/product/'+item.image"
                        :lazy-src="item.src"
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
                        </v-carousel-item>
                    </v-carousel>
                </v-row>
            </v-col>
            <!-- <v-row no-gutters>
                <v-col cols="1" v-for="(image,index) in images" :key="index" class="pr-1" >
                        <v-img 
                        :src="'/storage/thumb/'+image.image"
                        :lazy-src="'/storage/thumb/'+image.image"
                        
                        
                        class="border"
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
            </v-row> -->
        </v-card>   
    </div>
</template>
<script>
export default {
    props:['images'],
}
</script>