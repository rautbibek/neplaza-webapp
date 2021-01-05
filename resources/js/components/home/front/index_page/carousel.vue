<template>
  <div>
    <v-carousel hide-delimiters height="350" cycle>
      <v-carousel-item
        v-for="(item, i) in items"
        :key="i"
        :src="item.src"
      ></v-carousel-item>
      <v-overlay absolute opacity=".3">
        <h2>Buy And Sell Anything</h2>
      </v-overlay>
    </v-carousel>
  </div>
</template>

<script>
export default {
  data() {
    return {
      items: [
        {
          src: "/image/cover.jpeg",
        },
      ],
    };
  },
};
</script>
<style scoped>
h2 {
  font-family: "Nunito", sans-serif;
}
</style>

