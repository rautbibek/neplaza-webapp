<template>
  <div>
    <v-responsive>
      <v-img 
        class="white--text align-end image"
        aspect-ratio="1.4"
        max-height="190px"
        :src="ads.product_cover"
        lazy-src="/image/fabicon.ico"
      >
        <template v-slot:placeholder>
          <v-row class="fill-height ma-0" align="center" justify="center">
            <v-progress-circular
              indeterminate
              color="grey lighten-5"
            ></v-progress-circular>
          </v-row>
        </template>
        <div class="text-center">
          
          <v-chip  v-if="ads.product_property.status_name"
          x-small
          class="text-white text-uppercase mb-2"
          :color="ads.product_property.status_color">
          <v-icon left x-small>mdi-list-status</v-icon>
          {{ads.product_property.status_name}}        
        </v-chip>
        </div>
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
<style scoped>
.image{
  position: relative; 
  background: rgb(190, 194, 191);
}
</style>