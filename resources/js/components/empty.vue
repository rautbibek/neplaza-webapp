<template>
  <div class="container-fluid pa-3">
    <div class="text-center">
      <img height="230px" src="/image/no-data.webp" alt="" />
      <p class="no-products">{{ title || "No Products Found" }}</p>
      <v-btn
        class="sell-btn"
        dark
        tile
        v-if="!noButton"
        large
        color="#2f3b59"
        router
        :to="`/user/create/ads`"
      >
        START SELLING
      </v-btn>

      <br />
    </div>
  </div>
</template>
<script>
export default {
  props: ["title", "noButton"],
};
</script>
<style scoped>
.sell-btn {
  border-radius: 4px;
}
</style>
