<template>
  <div>
    <v-responsive>
      <v-img
        style="position: relative"
        class="white--text align-end"
        gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.3)"
        :height="height"
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
  computed: {
      height () {
        switch (this.$vuetify.breakpoint.name) {
          case 'xs': return '170px'
          case 'sm': return '190px'
          case 'md': return '190px'
          case 'lg': return '190px'
          case 'xl': return '190px'
        }
      },
    },
};
</script>
