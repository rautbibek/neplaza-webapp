<template>
  <div class="ad-card-body">
    <v-card-text text-left class="text-capitalize">
      <p class="d-inline-block text-truncate ad-title text-black">
        Rs. {{ ads.product_price }}
        {{ ads.product_max_price }}
      </p>
    </v-card-text>
    <v-card-subtitle class="text-capitalize pt-2"><div class="text--primary text-truncate py-1">
        {{ads.title}}
    </div></v-card-subtitle>
    
    <p class="text-black ad-address " >
      <v-icon color="#19916b" small>mdi-map-marker-circle</v-icon>
      {{ ads.product_property.nhood_name }},
      {{ ads.product_property.city_name }}
    </p>
    <!-- category name part -->
    <div class="d-none d-sm-flex">
      <v-chip  class="category ad-price " outlined small label>
        <v-icon x-small>query_builder</v-icon> &nbsp; {{ ads.created_date}}
      </v-chip>
      <v-chip class="category text-capitalize " outlined small label>
        <v-icon x-small left>mdi-account-circle</v-icon>{{ ads.product_property.user_name }}
      </v-chip>
      
    </div>
    <small class="d-flex d-sm-none" style="color:black"><v-icon x-small left>query_builder</v-icon>{{ ads.created_date}}</small>
  </div>
</template>
<script>
export default {
  props: ["ads"],
};
</script>
<style scoped>
.font{
  font-size:10px;
}
.text-capitalize {
  padding: 0px;
  display: flex;
}
.ad-price {
  margin-right: 5px;
}
.ad-title {
  margin-bottom: 0px;
  font-size: 16px;
  font-weight: 600;
}
.ad-card-body {
  padding: 12px;
}
.ad-address {
  font-size: 11px;
  display: inline-block;
  white-space: nowrap;
  text-overflow: ellipsis;
  overflow: hidden;
  width: 100%;
  margin-bottom: 6px;
  margin-top: 6px;
}
.text-black {
  color: black;
}
.category {
  padding: 0px 8px;
}
.category > i {
  margin-right: 3px;
}
</style>
