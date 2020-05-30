<template>

  <v-carousel  hide-delimiter-background hide-delimiters
 height="350" cycle>
    <v-carousel-item
      v-for="(item,i) in items"
      :key="i"
      :src="item.src"
    >
    </v-carousel-item>
    <v-overlay absolute><h2> Buy And Sell Anything </h2></v-overlay>
  </v-carousel>

</template>

<script>
  export default {
    data () {
      return {
        items: [

          {
            src: '/image/back.jpg',
          },
        ],
      }
    },
  }
</script>