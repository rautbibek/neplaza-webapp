<template>
  <div >
    <v-navigation-drawer class="drawer" style="min-height:550px" absolute permanent>
      <v-list dense class="p-0">
        <v-list-item-group v-model="item" color="primary">
          <v-list-item
            v-for="(item, i) in items"
            :key="i"
            router
            :to="item.url"
          >
                <v-list-item-icon>
                  <v-icon v-text="item.icon"></v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-title v-text="item.text"></v-list-item-title>
                </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>
    <div class="bottom-drawer">
      <v-btn
        small
        fab
        dark
        color="#2f3b59"
        class="icon-sm"
        @click="sheet = !sheet"
      >
        <v-icon>mdi-reorder-horizontal</v-icon>
      </v-btn>
      <v-bottom-sheet v-model="sheet">
        <v-sheet>
          <v-btn class="close" icon color="#373737" @click="sheet = !sheet">
            <v-icon>mdi-close</v-icon>
          </v-btn>
          <v-list dense class="p-0">
            <v-list-item-group v-model="item" color="primary">
              <v-list-item
                v-for="(item, i) in items"
                :key="i"
                router
                :to="item.url"
              >
                <v-tooltip left>
                  <template v-slot:activator="{ on, attrs }">
                    <v-list-item-icon v-bind="attrs" v-on="on">
                      <v-icon v-text="item.icon"></v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                      <v-list-item-title v-text="item.text"></v-list-item-title>
                    </v-list-item-content>
                  </template>
                  <span>{{ item.text }}</span>
                </v-tooltip>
              </v-list-item>
            </v-list-item-group>
          </v-list>
        </v-sheet>
      </v-bottom-sheet>
    </div>
  </div>
</template>
<script>
export default {
  props: ["drawer"],
  data: () => ({
    item: 1,
    sheet: false,
    items: [
      {
        text: "Active Products",
        icon: "mdi-clock",
        url: "/user/myads",
      },
      {
        text: "Deleted Products",
        icon: "delete",
        url: "/myads/deleted",
      },

      {
        text: "Featured Products",
        icon: "star",
        url: "/myads/feature",
      },
      {
        text: "Sold Products",
        icon: "money",
        url: "/myads/soldout",
      },

      {
        text: "Urgent Products",
        icon: "mdi-alert-circle",
        url: "/myads/urgent",
      },
    ],
  }),
};
</script>
<style scoped>
.drawer {
  padding-top: 50px;
  background: url("/image/default_cover.png") no-repeat center/cover;
}
.v-sheet {
  padding-top: 50px;
  position: relative;
}
.icon-sm {
  position: fixed;
  bottom: 16px;
  z-index: 100;
  left: 16px;
}
.close {
  position: absolute;
  top: 9px;
  right: 12px;
}
.expand-icon {
  position: absolute;
}
@media screen and (max-width: 768px) {
  .drawer {
    display: none;
  }
  .v-sheet .v-list-item--active {
    color: #19916b !important;
  }
}
@media screen and (min-width: 769px) {
  .bottom-drawer {
    display: none;
  }
}
</style>