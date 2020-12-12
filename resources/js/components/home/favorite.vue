<template>
  <v-btn
    @click="toggle"
    class="favourite"
    absolute
    x-small
    dark
    fab
    right
    :color="background"
  >
    <v-icon :color="color" v-if="fav">mdi-heart</v-icon>
    <v-icon :color="color" v-else>mdi-heart-outline</v-icon>
  </v-btn>
</template>
<script>
export default {
  props: ["is_favorite", "product_id"],
  data() {
    return {
      fav: this.is_favorite,
      id: this.product_id,
    };
  },
  methods: {
    toggle() {
      if (!this.loggedIn) {
        this.$toast.error("Please Login First", "Login", {
          timeout: 3000,
          position: "topRight",
        });
        //EventBus.$emit('changeDialog', true);
        return;
      }
      this.fav ? this.destroy() : this.create();
    },

    create() {
      this.fav = true;
      axios
        .post(this.url)
        .then((response) => {
          this.fav = true;
        })
        .catch();
    },

    destroy() {
      this.fav = false;
      axios
        .post(this.url)
        .then((response) => {
          this.fav = false;
        })
        .catch();
    },
  },

  computed: {
    color() {
      return this.fav ? "red" : "white";
    },
    background() {
      return this.fav ? "white" : "#2f3b59";
    },

    url() {
      return `/favorite/${this.id}/add`;
    },
  },
};
</script>
<style scoped>
.favourite {
  right: 8px;
  bottom: 8px;
}
</style>