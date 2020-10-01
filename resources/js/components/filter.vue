<template>
  <div v-if="count>0">
    <v-layout row wrap class="px-4 ">
      <v-flex xs12 sm6 md4 lg4 xl3 v-for="(ads,index) in all_ads" :key="index" >
          <card-lazy :ads="ads"></card-lazy>
      </v-flex>
    </v-layout>
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
