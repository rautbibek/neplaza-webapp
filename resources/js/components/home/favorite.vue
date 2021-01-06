<template>
  <v-btn @click="toggle" class="favourite-icon" v-if="fromDetails" x-small icon>
    <v-icon :color="colorOutlined" v-if="fav">mdi-heart</v-icon>
    <v-icon :color="colorOutlined" v-else>mdi-heart-outline</v-icon>
  </v-btn>
  <v-btn
    @click="toggle"
    v-else
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
  props: ["is_favorite", "product_id", "from_details"],
  data() {
    return {
      fav: this.is_favorite,
      id: this.product_id,
      fromDetails: this.from_details,
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
    colorOutlined() {
      return this.fav ? "red" : "#757575";
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
  bottom: 20px;
}
.favourite-icon i {
  font-size: 24px !important;
}
</style>