<template>
    <div>

        <v-lazy
         v-model="isActive"
         :options="{
         threshold: .2
         }"
         min-height="200"
         transition="fade-transition"
        >
            <v-hover v-slot:default="{ hover }"
            open-delay="100">
                <v-card tile :elevation="hover ? 16 : 3" class="ma-2 text-center">

                    <favorite :is_favorite='ads.favorite_to_users.length?true:false' :product_id="ads.id"></favorite>
                    <router-link :to="`/ad/detail/${ads.id}/${ads.slug}`">
                    <!-- image part -->
                    <cover :ads="ads"></cover>

                    <!-- date and user name part -->
                    <div class="card-date">
                        <card-date :ads="ads"></card-date>
                    </div>

                    <!-- title and subtitle part -->
                    <card-title :ads="ads"></card-title>
                    </router-link>
                </v-card>
            </v-hover>
        </v-lazy>

    </div>
</template>
<script>
export default {
    props:['ads'],
    data(){
        return{
            isActive : false,
        }
    }
}
</script>
