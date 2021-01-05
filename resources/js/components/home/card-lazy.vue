<template>
  <div>
    <v-lazy
      v-model="isActive"
      :options="{
        threshold: 0.1,
      }"
      
      transition="fade-transition"
    >
      <v-card tile class="ma-2 product-card" :width="width">
        <favorite
          :is_favorite="ads.favorite_to_users.length ? true : false"
          :product_id="ads.id"
        ></favorite>
        <router-link :to="`/ad/detail/${ads.id}/${ads.slug}`">
          <!-- image part -->
          <cover :ads="ads"></cover>

          <!-- title and subtitle part -->
          <card-title :ads="ads"></card-title>
        </router-link>
      </v-card>
    </v-lazy>
  </div>
</template>
<script>
export default {
  props: ["ads"],
  data() {
    return {
      isActive: false,
    };
  },
  computed: {
      width () {
        switch (this.$vuetify.breakpoint.name) {
          case 'xs': return 200
          case 'sm': return 
          case 'md': return 
          case 'lg': return 
          case 'xl': return 
        }
      },
    },
};
</script>
