<template>
  <div v-if="count>0">
    <v-container>
      <v-layout row wrap >
      <v-flex xs6 sm6 md4 lg3 xl3 v-for="(ads,index) in all_ads" :key="index" >
          <card-lazy :ads="ads"></card-lazy>
      </v-flex>
    </v-layout>
    </v-container>
  </div>
  <div v-else>
      <empty></empty>
  </div>
</template>

<script>
  export default {
    props:['all_ads','count'],
  }
</script>
