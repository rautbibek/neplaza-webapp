<template>
  <div>
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-menu>
      <template v-slot:activator="{ on: menu, attrs }">
        <v-tooltip bottom>
          <template v-slot:activator="{ on: tooltip }">
            <v-btn
              class="menu-settings-btn"
              x-small
              fab
              v-bind="attrs"
              v-on="{ ...tooltip, ...menu }"
            >
              <v-icon>mdi-cog</v-icon>
            </v-btn>
          </template>
          <span>Settings</span>
        </v-tooltip>
      </template>
      <v-list dense>
        <v-list-item-group color="primary">
          <v-list-item route :to="`/edit/${ads.id}/ad`">
            <v-list-item-icon>
              <v-icon small>edit</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Edit Detail</v-list-item-title>
            </v-list-item-content>
          </v-list-item>

          <v-list-item route :to="`/edit/ad/${ads.id}/image`">
            <v-list-item-icon>
              <v-icon small>image</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Edit Image</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item @click="softDelete(ads)">
            <v-list-item-icon>
              <v-icon small>delete</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Delete Ad</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item @click="soldOut(ads)">
            <v-list-item-icon>
              <v-icon small>money</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Sold Out</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-menu>
  </div>
</template>
<script>
//import action from "../../mixins/actions";
export default {
  props: ["ads"],
  data() {
    return {
      overlay: false,
    };
  },
  methods: {
    softDelete(ads) {
      if (
        confirm(
          "Are you sure you want to delete this? You can still recover the item later."
        )
      ) {
        this.overlay = true;
        axios
          .put(`/trash/ad/${ads.id}`)
          .then((response) => {
            this.$toast.success(response.data, "success", {
              timeout: 3000,
              position: "topRight",
            });
            EventBus.$emit("deleteAd", ads);
            this.overlay = false;
          })
          .catch();
      }
    },
    soldOut(ads) {
      this.overlay = true;
      axios
        .put(`/sold/ad/${ads.id}`)
        .then((response) => {
          this.$toast.success(response.data, "success", {
            timeout: 3000,
            position: "topRight",
          });
          EventBus.$emit("soldAd", ads);
          this.overlay = false;
        })
        .catch();
    },
  },
};
</script>
<style scoped>
.v-list-item__icon {
  margin-right: 0px !important;
}
.v-list a:hover {
  color: #19916b !important;
}
.v-list {
  min-width: 150px;
}
</style>