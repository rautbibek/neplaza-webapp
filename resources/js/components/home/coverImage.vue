<template>
  <div>
    <v-responsive>
      <v-img
        style="position: relative"
        class="white--text align-end"
        height="190px"
        :src="ads.product_cover"
        :lazy-src="ads.product_cover"
      >
        <template v-slot:placeholder>
          <v-row class="fill-height ma-0" align="center" justify="center">
            <v-progress-circular
              indeterminate
              color="grey lighten-5"
            ></v-progress-circular>
          </v-row>
        </template>
        <v-chip
            small
            class="mx-5 mb-2  d-sm-none"
            color="#000000ab"
            label
            text-color="white"
          >
            Rs. {{ ads.product_price }}
        {{ ads.product_max_price }}
          </v-chip>
      </v-img>
    </v-responsive>
  </div>
</template>
<script>
export default {
  props: ["ads"],
  data() {
    return {
      show: true,
    };
  },
  mounted() {
    // if(this.$route.params.id == this.ads.scategory_id){
    //   return this.show =false;
    // }
  },
};
</script>
